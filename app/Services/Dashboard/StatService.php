<?php

namespace App\Services\Dashboard;

use App\Concerns\SubordinateAccess;
use App\Models\Employee\Employee;
use App\Models\Leave\Request as LeaveRequest;
use App\Models\Payroll\Payroll;
use Illuminate\Http\Request;

class StatService
{
    use SubordinateAccess;

    public function getData(Request $request)
    {
        $accessibleEmployeeIds = $this->getAccessibleEmployee();

        $date = today()->toDateString();

        $employeeStat = Employee::query()
            ->selectRaw('count(*) as total_employee')
            ->selectRaw('count(case when employees.joining_date >= '."'".today()->startOfMonth()->toDateString()."'".' then 1 end) as total_employee_this_month')
            ->leftJoin('employee_records', function ($join) use ($date) {
                $join->on('employees.id', '=', 'employee_records.employee_id')->on('start_date', '=', \DB::raw("(select start_date from employee_records where employees.id = employee_records.employee_id and start_date <= '".$date."' order by start_date desc limit 1)"));
            })
            ->join('contacts', function ($join) {
                $join->on('employees.contact_id', '=', 'contacts.id')->where('contacts.team_id', session('team_id'));
            })
            ->first();

        $leaveStat = LeaveRequest::query()
            ->selectRaw('count(*) as total_leave_request')
            ->selectRaw('count(case when created_at >= '."'".today()->startOfMonth()->toDateString()."'".' then 1 end) as total_leave_request_this_month')
            ->whereIn('employee_id', $accessibleEmployeeIds)
            ->first();

        $payrollStat = Payroll::query()
            ->selectRaw('count(*) as total_payroll')
            ->selectRaw('count(case when created_at >= '."'".today()->startOfMonth()->toDateString()."'".' then 1 end) as total_payroll_this_month')
            ->whereIn('employee_id', $accessibleEmployeeIds)
            ->first();

        $stats = [
            [
                'title' => trans('dashboard.total_employee'),
                'count' => $employeeStat->total_employee,
                'icon' => 'fas fa-users',
                'color' => 'bg-success',
                'secondary_title' => trans('global.this_duration', ['attribute' => trans('list.durations.month')]),
                'secondary_count' => $employeeStat->total_employee_this_month,
            ],
            [
                'title' => trans('dashboard.total_leave_request'),
                'count' => $leaveStat->total_leave_request,
                'icon' => 'fas fa-sticky-note',
                'color' => 'bg-primary dark:bg-gray-700',
                'secondary_title' => trans('global.this_duration', ['attribute' => trans('list.durations.month')]),
                'secondary_count' => $leaveStat->total_leave_request_this_month,
            ],
            [
                'title' => trans('dashboard.total_payroll'),
                'count' => $payrollStat->total_payroll,
                'icon' => 'fas fa-file-contract',
                'color' => 'bg-info',
                'secondary_title' => trans('global.this_duration', ['attribute' => trans('list.durations.month')]),
                'secondary_count' => $payrollStat->total_payroll_this_month,
            ],
        ];

        return compact('stats');
    }
}
