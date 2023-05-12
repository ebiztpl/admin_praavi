<?php

namespace App\Services\Leave;

use App\Models\Leave\AllocationRecord as LeaveAllocationRecord;
use App\Models\Leave\Request as LeaveRequest;
use App\Models\Leave\Type as LeaveType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TypeService
{
    public function create(Request $request): LeaveType
    {
        \DB::beginTransaction();

        $leaveType = LeaveType::forceCreate($this->formatParams($request));

        \DB::commit();

        return $leaveType;
    }

    private function formatParams(Request $request, ?LeaveType $leaveType = null): array
    {
        $formatted = [
            'name' => $request->name,
            'alias' => $request->alias,
            'description' => $request->description,
        ];

        if (! $leaveType) {
            $formatted['team_id'] = session('team_id');
        }

        return $formatted;
    }

    public function update(Request $request, LeaveType $leaveType): void
    {
        \DB::beginTransaction();

        $leaveType->forceFill($this->formatParams($request, $leaveType))->save();

        \DB::commit();
    }

    public function deletable(LeaveType $leaveType): void
    {
        $leaveAllocationExists = LeaveAllocationRecord::whereLeaveTypeId($leaveType->id)->exists();

        if ($leaveAllocationExists) {
            throw ValidationException::withMessages(['message' => trans('global.associated_with_dependency', ['attribute' => trans('leave.type.type'), 'dependency' => trans('leave.allocation.allocation')])]);
        }

        $leaveRequestExists = LeaveRequest::whereLeaveTypeId($leaveType->id)->exists();

        if ($leaveRequestExists) {
            throw ValidationException::withMessages(['message' => trans('global.associated_with_dependency', ['attribute' => trans('leave.type.type'), 'dependency' => trans('leave.request.request')])]);
        }
    }
}
