<?php

return [
    'attendance' => 'Attendance',
    'attendances' => 'Attendances',
    'module_title' => 'List all Employee Attendance',
    'module_description' => 'Filter & get your employee\'s monthly attendance record either day wise or attendance head wise.',
    'is_time_based' => 'Time based Attendance',
    'mark' => 'Mark Attendance',
    'mark_production' => 'Mark Production based Attendance',
    'filter_record' => 'Filter records to get list of employee.',
    'not_marked' => 'Attendance not marked for given data.',
    'could_not_perform_if_payroll_generated' => 'Could not perform this operation as payroll is generated.',
    'could_not_perform_if_attendance_synched' => 'Could not remove attendance as attendance is synched.',
    'day_wise' => 'Day Wise',
    'config' => [
        'config' => 'Config',
        'props' => [
            'allow_employee_clock_in_out' => 'Allow Employees to Clock In/Out',
            'allow_employee_clock_in_out_via_device' => 'Allow Employees to Clock In/Out via Device',
        ],
    ],
    'props' => [
        'date' => 'Date of Attendance',
        'remarks' => 'Remarks',
        'value' => 'Value',
    ],
    'categories' => [
        'present' => 'Present',
        'holiday' => 'Holiday',
        'absent' => 'Absent',
        'leave' => 'Leave',
        'half_day' => 'Half Day',
        'production_based_earning' => 'Production based Earning',
        'production_based_deduction' => 'Production based Deduction',
    ],
    'production_units' => [
        'hourly' => 'Hourly',
    ],
    'type' => [
        'type' => 'Attendance Type',
        'types' => 'Attendance Types',
        'module_title' => 'Manage all Attendance Types',
        'module_description' => 'Attendance Type defines the category of each type of attendance available to employees of your company.',
        'module_example' => 'Present, Late, Absent are some examples of Attendance Types.',
        'could_not_perform_if_attendance_is_marked' => 'Could not perform this operation if attendance is marked.',
        'props' => [
            'name' => 'Name',
            'alias' => 'Alias',
            'code' => 'Code',
            'color' => 'Color',
            'category' => 'Category',
            'unit' => 'Unit',
            'description' => 'Description',
        ],
    ],
    'work_shift' => [
        'work_shift' => 'Work Shift',
        'work_shifts' => 'Work Shifts',
        'module_title' => 'Manage all Work Shifts',
        'module_description' => 'Work Shifts are the durations of time in which employees are expected to work.',
        'start_time_should_less_than_end_time' => 'Start time should less than end time.',
        'all_days_should_be_filled' => 'There are some missing or mismatch days in records.',
        'range_exists' => 'Work Shift for the employee already exists between :start and :end.',
        'assign' => 'Assign Work Shift',
        'props' => [
            'name' => 'Name',
            'code' => 'Code',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'is_holiday' => 'Holiday',
            'description' => 'Description',
            'remarks' => 'Remarks',
        ],
    ],
    'timesheet' => [
        'timesheet' => 'Timesheet',
        'timesheets' => 'Timesheets',
        'could_not_perform_without_work_shift' => 'Could not find any work shift.',
        'start_time_should_less_than_end_time' => 'Start time should less than end time.',
        'range_exists' => 'Timesheet already exists between :start and :end.',
        'could_not_perform_if_empty_out_at' => 'Could not perform this operation if any timesheet out time is empty.',
        'could_not_perform_if_attendance_synched' => 'Could not perform this operation as attendance is already synched.',
        'max_sync_count_limit_exceed' => 'Max sync count limit exceed.',
        'choose_date_range_to_sync' => 'Filter by date range to sync timesheet.',
        'already_synched' => 'Timesheet already synched for given employee on date.',
        'module_title' => 'Manage all Timesheets',
        'module_description' => 'Timesheet is the record of employee\'s attendance for a particular day.',
        'statuses' => [
            'ok' => 'OK',
            'missing_attendance_type' => 'Missing Attendance Type',
            'manual_attendance' => 'Manual Attendance',
            'already_synched' => 'Already Synched',
        ],
        'props' => [
            'manual' => 'Manual',
            'clock_in' => 'Clock In',
            'clock_out' => 'Clock Out',
            'in_at' => 'In at',
            'out_at' => 'Out at',
            'date' => 'Date',
            'duration' => 'Duration',
            'remarks' => 'Remarks',
        ],
    ],
];
