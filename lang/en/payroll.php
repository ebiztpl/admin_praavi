<?php

return [
    'payroll' => 'Payroll',
    'module_title' => 'Manage all Payrolls',
    'module_description' => 'Generate employee\'s Payroll based on the Attendance & Leave records for a particular duration.',
    'could_not_perform_if_payroll_generated_for_later_date' => 'Could not perform this operation if payroll already generated for later date.',
    'range_exists' => 'Payroll for the employee already generated between :start and :end.',
    'props' => [
        'code_number' => 'Payroll #',
        'amount' => 'Amount',
        'total' => 'Total',
        'paid' => 'Paid',
        'balance' => 'Balance',
        'status' => 'Status',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'remarks' => 'Remarks',
        'period' => 'Period',
        'duration' => 'Duration',
    ],
    'transaction' => [
        'transaction' => 'Transaction',
        'props' => [
            'amount' => 'Amount',
        ],
    ],
    'pay_head' => [
        'pay_head' => 'Pay Head',
        'module_title' => 'Manage all Pay Heads',
        'module_description' => 'Pay Head defines the components constituting salary structure of the employees of your company.',
        'module_example' => 'Basic Salary, Dearness Allowance, Provident Fund are some examples of Pay Heads.',
        'could_not_perform_if_associated_with_salary_template' => 'Could not perform this operation if pay head is associated with salary template.',
        'props' => [
            'name' => 'Name',
            'code' => 'Code',
            'alias' => 'Alias',
            'type' => 'Type',
            'description' => 'Description',
        ],
        'types' => [
            'earning' => 'Earning',
            'deduction' => 'Deduction',
        ],
        'categories' => [
            'not_applicable' => 'Not Applicable',
            'attendance_based' => 'Attendance Based',
            'flat_rate' => 'Flat Rate',
            'user_defined' => 'User Defined',
            'computation' => 'Computation',
            'production_based' => 'Production Based',
        ],
    ],
    'salary' => 'Salary',
    'salary_template' => [
        'salary_template' => 'Salary Template',
        'module_title' => 'Manage all Salary Templates',
        'module_description' => 'Salary Templates are predefined format of different pay heads used to create salary structure for your employees.',
        'computation_contains_self_pay_head' => 'Computation cannot contain self pay head.',
        'invalid_computation' => 'Invalid computation found.',
        'props' => [
            'name' => 'Name',
            'alias' => 'Alias',
            'description' => 'Description',
            'category' => 'Category',
            'computation' => 'Computation',
        ],
    ],
    'salary_structure' => [
        'salary_structure' => 'Salary Structure',
        'module_title' => 'Manage all Salary Structures',
        'module_description' => 'Salary structure is the details of the salary being offered, in terms of the breakup of the different components constituting the compensation.',
        'could_not_perform_if_defined_for_later_date' => 'Could not perform this operation if salary structure is already defined for later date.',
        'could_not_perform_if_payroll_generated' => 'Could not perform this operation if payroll already generated before this date.',
        'units' => [
            'monthly' => 'Monthly',
        ],
        'props' => [
            'effective_date' => 'Effective Date',
            'net_earning' => 'Net Earning',
            'net_deduction' => 'Net Deduction',
            'net_salary' => 'Net Salary',
            'amount' => 'Amount',
            'description' => 'Description',
        ],
    ],
    'config' => [
        'props' => [
            'number_prefix' => 'Code Number Prefix',
            'number_suffix' => 'Code Number Suffix',
            'number_digit' => 'Code Number Digit',
        ],
    ],
];
