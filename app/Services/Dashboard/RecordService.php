<?php

namespace App\Services\Dashboard;

use App\Concerns\SubordinateAccess;
use App\Http\Resources\Leave\RequestResource as LeaveRequestResource;
use App\Http\Resources\Payroll\PayrollResource;
use App\Models\Leave\Request as LeaveRequest;
use App\Models\Payroll\Payroll;
use Illuminate\Http\Request;

class RecordService
{
    use SubordinateAccess;

    public function getData(Request $request): array
    {
        $accessibleEmployeeIds = $this->getAccessibleEmployee();

        $leaveRequests = LeaveRequestResource::collection(LeaveRequest::query()
            ->with(['employee' => fn ($q) => $q->withSummaryRecord(), 'type'])
            ->whereIn('employee_id', $accessibleEmployeeIds)
            ->latest()
            ->take(5)
            ->get());

        $payrolls = PayrollResource::collection(Payroll::query()
            ->with(['employee' => fn ($q) => $q->withSummaryRecord()])
            ->whereIn('employee_id', $accessibleEmployeeIds)
            ->latest()
            ->take(5)
            ->get());

        return compact('leaveRequests', 'payrolls');
    }
}
