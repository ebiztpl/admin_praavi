<?php

namespace App\Concerns;

trait ModelRelation
{
    /**
     * Get all relations
     *
     * @return array
     */
    public function relations()
    {
        return [
            'Team' => 'App\Models\Team',
            'User' => 'App\Models\User',
            'Tag' => 'App\Models\Tag',
            'Comment' => 'App\Models\Comment',
            'Config' => 'App\Models\Config\Config',
            'Todo' => 'App\Models\Utility\Todo',
            'Role' => 'App\Models\Config\Role',
            'Option' => 'App\Models\Option',
            'Account' => 'App\Models\Account',
            'Department' => 'App\Models\Department',
            'Designation' => 'App\Models\Designation',
            'Branch' => 'App\Models\Branch',
            'Employee' => 'App\Models\Employee\Employee',
            'EmployeeRecord' => 'App\Models\Employee\Record',
            'EmployeeQualification' => 'App\Models\Employee\Qualification',
            'EmployeeDocument' => 'App\Models\Employee\Document',
            'EmployeeExperience' => 'App\Models\Employee\Experience',
            'LeaveType' => 'App\Models\Leave\Type',
            'LeaveAllocation' => 'App\Models\Leave\Allocation',
            'LeaveRequest' => 'App\Models\Leave\Request',
            'AttendanceType' => 'App\Models\Attendance\Type',
            'Attendance' => 'App\Models\Attendance\Attendance',
            'WorkShift' => 'App\Models\Attendance\WorkShift',
            'Timesheet' => 'App\Models\Attendance\Timesheet',
            'LedgerType' => 'App\Models\Finance\LedgerType',
            'Ledger' => 'App\Models\Finance\Ledger',
            'Transaction' => 'App\Models\Finance\Transaction',
            'Payroll' => 'App\Models\Payroll\Payroll',
            'SalaryTemplate' => 'App\Models\Payroll\SalaryTemplate',
            'SalaryStructure' => 'App\Models\Payroll\SalaryStructure',
            'Task' => 'App\Models\Task\Task',
            'TaskChecklist' => 'App\Models\Task\Checklist',
        ];
    }
}
