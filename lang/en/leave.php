<?php

return [
    'leave' => 'Leave',
    'on_leave' => 'On Leave',
    'request' => [
        'request' => 'Leave Request',
        'module_title' => 'Manage all Leave Requests',
        'module_description' => 'Leave requests submitted by your employees can be approved, rejected by authorized employee.',
        'action' => 'Action',
        'status_is_not_requested' => 'Could not update leave request if status is not requested.',
        'range_exists' => 'Leave request for the employee already exists between :start and :end.',
        'could_not_perform_if_status_updated' => 'Could not perform this operation if status is already updated.',
        'could_not_perform_if_payroll_generated' => 'Could not perform this operation if payroll is generated for this duration.',
        'statuses' => [
            'requested' => 'Requested',
            'rejected' => 'Rejected',
            'approved' => 'Approved',
            'withdrawn' => 'Withdrawn',
        ],
        'props' => [
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'reason' => 'Reason',
            'requester' => 'Requester',
            'approver' => 'Approver',
            'comment' => 'Comment',
            'period' => 'Period',
            'duration' => 'Duration',
        ],
    ],
    'allocation' => [
        'allocation' => 'Leave Allocation',
        'module_title' => 'Manage all Leave Allocation',
        'module_description' => 'Assign leave allocation to your employees for a particular duration.',
        'range_exists' => 'Leave allocation for the employee already exists between :start and :end.',
        'use_count_gt_allocated' => 'Allotted leave :allotted cannot less than use count :used.',
        'start_date_gt_first_leave_request_date' => 'Start date cannot greater than first leave request date :date.',
        'end_date_lt_last_leave_request_date' => 'End date cannot less than last leave request date :date.',
        'could_not_perform_if_leave_requested' => 'Could not perform this operation if leave request is already made.',
        'could_not_perform_if_leave_utilized' => 'Could not perform this operation if leave is already utilized.',
        'props' => [
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'description' => 'Description',
            'allotted' => 'Leaves Allotted',
            'used' => 'Leaves Used',
        ],
    ],
    'config' => [
        'config' => 'Config',
        'props' => [

        ],
    ],
    'type' => [
        'type' => 'Leave Type',
        'module_title' => 'Manage all Leave Types',
        'module_description' => 'Leave Type defines the category of each type of leave available to employees of your company.',
        'module_example' => 'Sick leave, Casual leave, Maternity leave are some examples of Leave Types.',
        'no_allocation_found' => 'Could not find any leave allocation for this leave type.',
        'balance_exhausted' => 'Available leave balance is :balance, cannot request for :duration day(s) leave.',
        'props' => [
            'name' => 'Name',
            'alias' => 'Alias',
            'description' => 'Description',
        ],
    ],
];
