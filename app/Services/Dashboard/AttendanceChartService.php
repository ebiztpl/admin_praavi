<?php

namespace App\Services\Dashboard;

use App\Concerns\SubordinateAccess;
use App\Helpers\CalHelper;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\Type as AttendanceType;
use Illuminate\Http\Request;

class AttendanceChartService
{
    use SubordinateAccess;

    public function getData(Request $request): array
    {
        $accessibleEmployeeIds = $this->getAccessibleEmployee();

        $date = today();

        $attendanceTypes = AttendanceType::byTeam()->direct()->get();

        $query = Attendance::query()
            ->select('date')
            ->whereIn('employee_id', $accessibleEmployeeIds)
            ->whereBetween('date', [today()->subWeek(2)->toDateString(), today()->toDateString()]);

        $codes = [];
        foreach ($attendanceTypes as $attendanceType) {
            $codes[] = $attendanceType->code;
            $query->selectRaw('count(case when attendance_type_id = '.$attendanceType->id.' then 1 end) as '.$attendanceType->code);
        }

        $attendances = $query
            ->selectRaw("count(case when attendance_symbol = 'L' then 1 end) as L")
            ->groupBy('date')
            ->get();

        foreach ($attendanceTypes as $attendanceType) {
        }

        $labels = [];
        $datasets = [];

        $items = collect([]);
        while ($date > today()->subWeek(2)) {
            $labels[] = CalHelper::showDate($date->toDateString());

            $hasAttendance = $attendances->firstWhere('date', $date->toDateString());

            if (! $hasAttendance) {
                $attendance['date'] = $date->toDateString();
                foreach ($codes as $code) {
                    $attendance[$code] = 0;
                }
                $attendance['L'] = 0;
                $items->push($attendance);
            } else {
                $items->push($hasAttendance);
            }

            $date->subDays(1);
        }

        foreach ($codes as $code) {
            $attendanceType = $attendanceTypes->firstWhere('code', $code);
            $datasets[] = [
                'label' => $attendanceType->name,
                'data' => $items->pluck($code)->all(),
                'backgroundColor' => $attendanceType->color,
                'borderColor' => $attendanceType->color,
            ];
        }

        $datasets[] = [
            'label' => trans('attendance.categories.leave'),
            'data' => $items->pluck('L')->all(),
            'backgroundColor' => '#D82161',
            'borderColor' => '#D82161',
        ];

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }
}
