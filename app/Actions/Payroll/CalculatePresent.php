<?php

namespace App\Actions\Payroll;

use App\Enums\Attendance\Category as AttendanceCategory;
use App\Models\Attendance\Attendance;
use Illuminate\Support\Collection;

class CalculatePresent
{
    public function execute(Attendance $attendance, Collection $attendanceTypes): float
    {
        $present = $attendance?->L ?? 0;
        $halfDay = 0;

        foreach ($attendanceTypes->whereIn('category', [AttendanceCategory::PRESENT->value, AttendanceCategory::HOLIDAY->value]) as $attendanceType) {
            $attendanceCode = $attendanceType->code;
            $present += $attendance?->$attendanceCode ?? 0;
        }

        foreach ($attendanceTypes->whereIn('category', [AttendanceCategory::HALF_DAY->value]) as $attendanceType) {
            $attendanceCode = $attendanceType->code;
            $halfDay += $attendance?->$attendanceCode ?? 0;
        }

        $present += ($halfDay / 2);

        return $present;
    }
}
