<?php

namespace App\Actions\Payroll;

use App\Enums\Attendance\Category as AttendanceCategory;
use App\Models\Attendance\Attendance;
use Illuminate\Support\Collection;

class GetAttendanceSummary
{
    public function execute(Attendance $attendance, Collection $attendanceTypes): array
    {
        $attendances = [];

        array_push($attendances, [
            'code' => 'L',
            'name' => trans('leave.leave'),
            'count' => $attendance?->L ?? 0,
            'color' => 'danger',
            'unit' => 'days',
        ]);

        foreach ($attendanceTypes as $attendanceType) {
            $attendanceCode = $attendanceType->code;
            array_push($attendances, [
                'code' => $attendanceType->code,
                'name' => $attendanceType->name,
                'count' => $attendance?->$attendanceCode ?? 0,
                'color' => AttendanceCategory::getColor($attendanceType->category),
                'unit' => 'days',
            ]);
        }

        return $attendances;
    }
}
