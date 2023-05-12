<?php

namespace App\Actions\Payroll;

use App\Models\Attendance\Attendance;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class GetAttendanceBetweenPeriod
{
    public function execute(int $employeeId, string $startDate, string $endDate, Collection $attendanceTypes): Attendance
    {
        $query = Attendance::query()
            ->select('employee_id')
            ->where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate]);

        foreach ($attendanceTypes as $attendanceType) {
            $query->selectRaw('count(case when attendance_type_id = '.$attendanceType->id.' then 1 end) as '.$attendanceType->code);
        }

        $attendance = $query
            ->selectRaw("count(case when attendance_symbol = 'L' then 1 end) as L")
            ->groupBy('employee_id')
            ->first();

        if (! $attendance) {
            throw ValidationException::withMessages(['start_date' => trans('attendance.not_marked')]);
        }

        return $attendance;
    }
}
