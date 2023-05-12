<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Config\Config' => 'App\Policies\Config\ConfigPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Utility\Todo' => 'App\Policies\Utility\TodoPolicy',
        'App\Models\Company\Department' => 'App\Policies\Company\DepartmentPolicy',
        'App\Models\Company\Designation' => 'App\Policies\Company\DesignationPolicy',
        'App\Models\Company\Branch' => 'App\Policies\Company\BranchPolicy',
        'App\Models\Employee\Employee' => 'App\Policies\Employee\EmployeePolicy',
        'App\Models\Finance\Ledger' => 'App\Policies\Finance\LedgerPolicy',
        'App\Models\Finance\Transaction' => 'App\Policies\Finance\TransactionPolicy',
        'App\Models\Calendar\Holiday' => 'App\Policies\Calendar\HolidayPolicy',
        'App\Models\Leave\Allocation' => 'App\Policies\Leave\AllocationPolicy',
        'App\Models\Leave\Request' => 'App\Policies\Leave\RequestPolicy',
        'App\Models\Attendance\Attendance' => 'App\Policies\Attendance\AttendancePolicy',
        'App\Models\Attendance\WorkShift' => 'App\Policies\Attendance\WorkShiftPolicy',
        'App\Models\Attendance\Timesheet' => 'App\Policies\Attendance\TimesheetPolicy',
        'App\Models\Payroll\Payroll' => 'App\Policies\Payroll\PayrollPolicy',
        'App\Models\Payroll\SalaryTemplate' => 'App\Policies\Payroll\SalaryTemplatePolicy',
        'App\Models\Payroll\SalaryStructure' => 'App\Policies\Payroll\SalaryStructurePolicy',
        'App\Models\Task\Task' => 'App\Policies\Task\TaskPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return ($user->is_default || $user->hasRole('admin')) ? true : null;
        });

        // Gate::after(function ($user, $ability) {
        //     return $user->hasRole('admin');
        // });
    }
}
