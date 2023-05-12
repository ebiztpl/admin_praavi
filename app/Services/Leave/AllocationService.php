<?php

namespace App\Services\Leave;

use App\Concerns\SubordinateAccess;
use App\Helpers\CalHelper;
use App\Http\Resources\Leave\TypeResource as LeaveTypeResource;
use App\Models\Leave\Allocation as LeaveAllocation;
use App\Models\Leave\AllocationRecord as LeaveAllocationRecord;
use App\Models\Leave\Request as LeaveRequest;
use App\Models\Leave\Type as LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AllocationService
{
    use SubordinateAccess;

    public function preRequisite(Request $request): array
    {
        $leaveTypes = LeaveTypeResource::collection(LeaveType::byTeam()->get());

        return compact('leaveTypes');
    }

    public function create(Request $request): LeaveAllocation
    {
        \DB::beginTransaction();

        $leaveAllocation = LeaveAllocation::forceCreate($this->formatParams($request));

        $this->updateRecords($request, $leaveAllocation);

        \DB::commit();

        return $leaveAllocation;
    }

    private function formatParams(Request $request, ?LeaveAllocation $leaveAllocation = null): array
    {
        $formatted = [
            'employee_id' => $request->employee_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ];

        if (! $leaveAllocation) {
            //
        }

        return $formatted;
    }

    private function updateRecords(Request $request, LeaveAllocation $leaveAllocation): void
    {
        $leaveTypeIds = [];
        foreach ($request->records as $index => $record) {
            $leaveAllocationRecord = LeaveAllocationRecord::firstOrCreate([
                'leave_allocation_id' => $leaveAllocation->id,
                'leave_type_id' => Arr::get($record, 'leave_type.id'),
            ]);

            if ($leaveAllocationRecord->used > Arr::get($record, 'allotted', 0)) {
                throw ValidationException::withMessages(['records.'.$index.'.allotted' => trans('leave.allocation.use_count_gt_allocated', ['allotted' => Arr::get($record, 'allotted', 0), 'used' => $leaveAllocationRecord->used])]);
            }

            $leaveAllocationRecord->uuid = $leaveAllocationRecord->uuid ?? (string) Str::uuid();
            $leaveAllocationRecord->allotted = Arr::get($record, 'allotted', 0);
            $leaveAllocationRecord->save();

            $leaveTypeIds[] = Arr::get($record, 'leave_type.id');
        }

        LeaveAllocationRecord::whereLeaveAllocationId($leaveAllocation->id)->where(function ($q) use ($leaveTypeIds) {
            $q->whereNotIn('leave_type_id', $leaveTypeIds)->orWhere('allotted', '=', 0);
        })->delete();
    }

    private function isEditable(Request $request, LeaveAllocation $leaveAllocation): void
    {
        $leaveRequests = LeaveRequest::query()
            ->whereEmployeeId($leaveAllocation->employee_id)
            ->where('start_date', '>=', $leaveAllocation->start_date)
            ->where('end_date', '<=', $leaveAllocation->end_date)
            ->get();

        if (! $leaveRequests->count()) {
            return;
        }

        if ($request->employee_id != $leaveAllocation->employee_id) {
            throw ValidationException::withMessages(['employee' => trans('leave.allocation.could_not_perform_if_leave_requested')]);
        }

        $firstLeaveRequestDate = $leaveRequests->sortBy('start_date')->first()->start_date;
        $lastLeaveRequestDate = $leaveRequests->sortByDesc('end_date')->first()->end_date;

        if ($request->start_date > $firstLeaveRequestDate) {
            throw ValidationException::withMessages(['start_date' => trans('leave.allocation.start_date_gt_first_leave_request_date', ['date' => CalHelper::showDate($firstLeaveRequestDate)])]);
        }

        if ($request->end_date < $lastLeaveRequestDate) {
            throw ValidationException::withMessages(['end_date' => trans('leave.allocation.end_date_lt_last_leave_request_date', ['date' => CalHelper::showDate($lastLeaveRequestDate)])]);
        }
    }

    public function update(Request $request, LeaveAllocation $leaveAllocation): void
    {
        $this->isEditable($request, $leaveAllocation);

        \DB::beginTransaction();

        $leaveAllocation->forceFill($this->formatParams($request, $leaveAllocation))->save();

        $this->updateRecords($request, $leaveAllocation);

        \DB::commit();
    }

    public function deletable(LeaveAllocation $leaveAllocation): void
    {
        $usedLeaveAllocation = $leaveAllocation->records()->where('used', '>', 0)->count();

        if ($usedLeaveAllocation) {
            throw ValidationException::withMessages(['message' => trans('leave.allocation.could_not_delete_if_utilized')]);
        }
    }
}
