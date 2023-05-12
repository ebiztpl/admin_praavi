<?php

namespace App\Services\Attendance;

use App\Actions\Employee\FetchEmployee;
use App\Contracts\ListGenerator;
use App\Enums\Attendance\Category as AttendanceCategory;
use App\Http\Resources\Employee\EmployeeAttendanceResource;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\Type as AttendanceType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class AttendanceListService extends ListGenerator
{
    public function getHeaders(Request $request): array
    {
        $headers = [
            [
                'key' => 'employee',
                'label' => trans('employee.employee'),
                'print_label' => 'name',
                'visibility' => true,
            ],
        ];

        if ($request->boolean('day_wise')) {
            return $this->getDayWiseHeaders($request, $headers);
        }

        return $this->getSummaryHeaders($request, $headers);
    }

    private function getSummaryHeaders(Request $request, array $headers): array
    {
        foreach ($request->attendance_types as $attendanceType) {
            array_push($headers, [
                'key' => 'type_'.Arr::get($attendanceType, 'code'),
                'label' => Arr::get($attendanceType, 'name'),
                'print_label' => 'summary._'.Arr::get($attendanceType, 'code'),
                'center_align' => true,
                'visibility' => true,
            ]);
        }

        return $headers;
    }

    private function getDayWiseHeaders(Request $request, array $headers): array
    {
        $date = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        while ($date <= $endDate) {
            $day = $date->format('d');
            $singleDay = $date->format('j');

            array_push($headers, [
                'key' => 'day_'.$singleDay,
                'label' => $singleDay,
                'print_label' => 'attendances._'.$day.'.code',
                'visibility' => true,
            ]);

            $date->addDay(1);
        }

        return $headers;
    }

    public function paginate(Request $request): AnonymousResourceCollection
    {
        $request->validate(['date' => 'required|date']);

        $request->merge(['month_wise' => true]);

        $employees = (new FetchEmployee)->execute($request);

        $attendanceTypes = AttendanceType::byTeam()->direct()->get();
        $attendanceTypeSummaries = $this->getAttendanceTypeSummary($attendanceTypes);

        $request->merge(['attendance_types' => $attendanceTypeSummaries]);

        if ($request->boolean('day_wise')) {
            $employees = $this->getDayWiseRecords($request, $employees, $attendanceTypes);
        } else {
            $employees = $this->getSummaryRecords($request, $employees, $attendanceTypes);
        }

        return EmployeeAttendanceResource::collection($employees)
            ->additional([
                'headers' => $this->getHeaders($request),
            ]);
    }

    private function getAttendanceTypeSummary(Collection $attendanceTypes): Collection
    {
        $attendanceTypeSummaries = $attendanceTypes->map(function ($attendanceType) {
            return [
                'code' => $attendanceType->code,
                'category' => $attendanceType->category,
                'name' => $attendanceType->name,
            ];
        });

        $attendanceTypeSummaries->push([
            'code' => 'L',
            'category' => 'leave',
            'name' => trans('leave.leave'),
        ]);

        return $attendanceTypeSummaries;
    }

    private function getDayWiseRecords(Request $request, LengthAwarePaginator $employees, Collection $attendanceTypes): LengthAwarePaginator
    {
        $attendances = Attendance::query()
            ->select('employee_id', 'remarks', 'date', 'attendance_symbol', 'attendance_types.name', 'attendance_types.category', 'attendance_types.code')
            ->leftJoin('attendance_types', function ($join) {
                $join->on('attendances.attendance_type_id', '=', 'attendance_types.id');
            })
            ->whereIn('employee_id', $employees->pluck('id')->all())
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->get();

        foreach ($employees as $employee) {
            $employeeAttendances = $attendances->where('employee_id', $employee->id);

            $date = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);

            $items = [];
            while ($date <= $endDate) {
                $day = $date->format('d');
                $singleDay = $date->format('j');

                $employeeAttendance = $employeeAttendances->firstWhere('date', $date->toDateString());

                $items['_'.$singleDay] = $this->getAttendance($employeeAttendance);

                $date->addDay(1);
            }

            $employee->list_attendance = true;
            $employee->attendances = $items;
        }

        return $employees;
    }

    private function getAttendance(?Attendance $employeeAttendance)
    {
        if (! $employeeAttendance) {
            return [
                'code' => '',
                'label' => '',
                'color' => AttendanceCategory::getColor(''),
            ];
        }

        if ($employeeAttendance->attendance_symbol == 'L') {
            return [
                'code' => 'L',
                'label' => trans('leave.leave'),
                'color' => 'danger',
            ];
        }

        return [
            'code' => $employeeAttendance->code,
            'label' => $employeeAttendance->name,
            'color' => AttendanceCategory::getColor($employeeAttendance->category),
        ];
    }

    private function getSummaryRecords(Request $request, LengthAwarePaginator $employees, Collection $attendanceTypes): LengthAwarePaginator
    {
        $query = Attendance::query()
            ->select('employee_id')
            ->whereIn('employee_id', $employees->pluck('id')->all())
            ->whereBetween('date', [$request->start_date, $request->end_date]);

        foreach ($attendanceTypes as $attendanceType) {
            $query->selectRaw('count(case when attendance_type_id = '.$attendanceType->id.' then 1 end) as '.$attendanceType->code);
        }

        $attendances = $query
            ->selectRaw("count(case when attendance_symbol = 'L' then 1 end) as L")
            ->groupBy('employee_id')
            ->get();

        foreach ($employees as $employee) {
            $employeeSummary = $attendances->firstWhere('employee_id', $employee->id);

            $summary = [];
            foreach ($attendanceTypes as $attendanceType) {
                $code = $attendanceType->code;
                $summary['_'.$code] = $employeeSummary?->$code ?? 0;
            }
            $summary['_L'] = $employeeSummary?->L ?? 0;

            $employee->list_summary = true;
            $employee->summary = $summary;
        }

        return $employees;
    }

    public function list(Request $request): AnonymousResourceCollection
    {
        return $this->paginate($request);
    }
}
