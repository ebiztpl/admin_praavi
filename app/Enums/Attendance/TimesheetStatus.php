<?php

namespace App\Enums\Attendance;

use App\Concerns\HasEnum;

enum TimesheetStatus: string
{
    use HasEnum;

    case OK = 'ok';
    case ALREADY_SYNCHED = 'already_synched';
    case MANUAL_ATTENDANCE = 'manual_attendance';
    case MISSING_ATTENDANCE_TYPE = 'missing_attendance_type';

    public static function translation(): string
    {
        return 'attendance.timesheet.statuses.';
    }
}
