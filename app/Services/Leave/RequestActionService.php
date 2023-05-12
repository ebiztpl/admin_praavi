<?php

namespace App\Services\Leave;

use App\Enums\Leave\RequestStatus as LeaveRequestStatus;
use App\Helpers\CalHelper;
use App\Models\Attendance\Attendance;
use App\Models\Leave\AllocationRecord as LeaveAllocationRecord;
use App\Models\Leave\Request as LeaveRequest;
use App\Models\Leave\RequestRecord as LeaveRequestRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RequestActionService
{
    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
    {
        \DB::beginTransaction();

        $this->updateLeaveBalance($request, $leaveRequest, 'decrement');

        $leaveRequestRecord = LeaveRequestRecord::firstOrCreate([
            'leave_request_id' => $leaveRequest->id,
        ]);

        $leaveRequestRecord->approve_user_id = auth()->id();
        $leaveRequestRecord->status = $request->status;
        $leaveRequestRecord->comment = $request->comment;
        $leaveRequestRecord->save();

        $leaveRequest->status = $request->status;
        $leaveRequest->save();

        $this->updateLeaveBalance($request, $leaveRequest);

        $this->updateAttendance($leaveRequest);

        \DB::commit();
    }

    private function updateLeaveBalance(Request $request, LeaveRequest $leaveRequest, $action = 'increment'): void
    {
        if (! in_array($leaveRequest->status, [LeaveRequestStatus::APPROVED->value])) {
            return;
        }

        LeaveAllocationRecord::query()
            ->whereLeaveAllocationId($request->leave_allocation_id)
            ->whereLeaveTypeId($leaveRequest->leave_type_id)
            ->$action('used', $request->duration);
    }

    private function updateAttendance(LeaveRequest $leaveRequest): void
    {
        $dates = CalHelper::datesInPeriod($leaveRequest->start_date, $leaveRequest->end_date);

        if ($leaveRequest->status != LeaveRequestStatus::APPROVED->value) {
            Attendance::whereIn('date', $dates)->whereEmployeeId($leaveRequest->employee_id)->whereAttendanceSymbol('L')->delete();

            return;
        }

        Attendance::whereIn('date', $dates)->whereEmployeeId($leaveRequest->employee_id)->whereNull('attendance_symbol')->delete();

        $attendances = [];
        foreach ($dates as $date) {
            $attendances[] = ['date' => $date, 'employee_id' => $leaveRequest->employee_id, 'attendance_symbol' => 'L', 'attendance_type_id' => null, 'uuid' => (string) Str::uuid()];
        }

        Attendance::upsert($attendances,
            ['date', 'employee_id'], ['attendance_symbol', 'attendance_type_id', 'uuid']);
    }
}
