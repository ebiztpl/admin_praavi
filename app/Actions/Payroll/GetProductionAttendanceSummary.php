<?php

namespace App\Actions\Payroll;

use App\Enums\Attendance\Category as AttendanceCategory;
use Illuminate\Support\Collection;

class GetProductionAttendanceSummary
{
    public function execute(Collection $attendanceRecords, Collection $productionAttendanceTypes, array $attendanceSummary = []): array
    {
        foreach ($productionAttendanceTypes as $productionAttendanceType) {
            array_push($attendanceSummary, [
                'code' => $productionAttendanceType->code,
                'name' => $productionAttendanceType->name,
                'count' => $attendanceRecords->where('attendance_type_id', $productionAttendanceType->id)->sum('value'),
                'color' => AttendanceCategory::getColor($productionAttendanceType->category),
                'unit' => 'hours',
            ]);
        }

        return $attendanceSummary;
    }
}
