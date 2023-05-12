<?php

namespace App\Services\Attendance;

use App\Actions\Employee\FetchEmployee;
use App\Enums\Attendance\Category as AttendanceCategory;
use App\Enums\Attendance\ProductionUnit as AttendanceProductionUnit;
use App\Enums\Leave\RequestStatus as LeaveRequestStatus;
use App\Http\Resources\Attendance\TypeResource as AttendanceTypeResource;
use App\Http\Resources\Employee\EmployeeAttendanceResource;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\Record;
use App\Models\Attendance\Type as AttendanceType;
use App\Models\Calendar\Holiday;
use App\Models\Leave\Request as LeaveRequest;
use App\Models\Payroll\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class AttendanceService
{
    public function preRequisite(Request $request)
    {
        $attendanceTypes = AttendanceTypeResource::collection(AttendanceType::byTeam()->direct()->get());

        return compact('attendanceTypes');
    }

    public function fetch(Request $request)
    {
        $request->merge(['hide_employee_with_payroll' => true]);
        $request->validate(['date' => 'required|date']);

        $employees = (new FetchEmployee)->execute($request);
        $employeeIds = $employees->pluck('id')->all();

        $attendances = Attendance::query()
            ->select('employee_id', 'attendance_type_id', 'remarks', 'is_time_based', 'attendance_types.uuid')
            ->join('attendance_types', function ($join) {
                $join->on('attendances.attendance_type_id', '=', 'attendance_types.id');
            })
            ->whereIn('employee_id', $employeeIds)
            ->where('date', $request->date)
            ->get();

        $attendanceTypes = AttendanceType::byTeam()->direct()->get();
        $holidayAttendanceType = $attendanceTypes?->firstWhere('category', AttendanceCategory::HOLIDAY->value);

        $holiday = Holiday::query()
            ->where('start_date', '<=', $request->date)
            ->where('end_date', '>=', $request->date)
            ->first();

        $leaveRequests = LeaveRequest::query()
            ->whereIn('employee_id', $employeeIds)
            ->whereStatus(LeaveRequestStatus::APPROVED->value)
            ->where('start_date', '<=', $request->date)
            ->where('end_date', '>=', $request->date)
            ->get();

        foreach ($employees as $employee) {
            $attendance = $attendances->firstWhere('employee_id', $employee->id);

            if (! $attendance) {
                if ($holiday) {
                    $employee->attendance_type = $holidayAttendanceType?->uuid;
                }

                $leaveRequest = $leaveRequests->firstWhere('employee_id', $employee->id);

                if ($leaveRequest) {
                    $employee->on_leave = true;
                    $employee->leave_period = $leaveRequest->period;
                }
            } else {
                $employee->attendance_type = $attendance?->uuid;
            }

            $employee->time_based_attendance = $attendance?->is_time_based ? true : false;
            $employee->mark_attendance = true;
            $employee->remarks = $attendance?->remarks;
        }

        return EmployeeAttendanceResource::collection($employees);
    }

    private function ensureAttendanceNotSynched(Request $request, array $employees): void
    {
        $employeeIds = [];

        foreach ($request->employees as $input) {
            $employee = Arr::first($employees, function ($item) use ($input) {
                return Arr::get($item, 'uuid') == Arr::get($input, 'uuid');
            });

            if (! Arr::get($input, 'attendance_type_id')) {
                $employeeIds[] = Arr::get($employee, 'id');
            }
        }

        if (! $employeeIds) {
            return;
        }

        $synchedAttendanceExists = Attendance::query()
            ->whereIn('employee_id', $employeeIds)
            ->where('date', $request->date)
            ->whereIsTimeBased(1)
            ->exists();

        if ($synchedAttendanceExists) {
            throw ValidationException::withMessages(['message' => trans('attendance.could_not_perform_if_attendance_synched')]);
        }
    }

    public function mark(Request $request)
    {
        $request->merge(['hide_employee_with_payroll' => true]);

        $employees = Arr::get((new FetchEmployee)->execute($request, true), 'data', []);

        if (array_diff(Arr::pluck($request->employees, 'uuid'), Arr::pluck($employees, 'uuid'))) {
            throw ValidationException::withMessages(['message' => trans('general.errors.invalid_input')]);
        }

        $this->ensureAttendanceNotSynched($request, $employees);

        $employeesWithoutAttendance = [];
        foreach ($request->employees as $input) {
            $employee = Arr::first($employees, function ($item) use ($input) {
                return Arr::get($item, 'uuid') == Arr::get($input, 'uuid');
            });

            if (Arr::get($employee, 'on_leave')) {
            } elseif (! Arr::get($input, 'attendance_type_id')) {
                $employeesWithoutAttendance[] = Arr::get($employee, 'id');
            } else {
                $attendance = Attendance::firstOrCreate([
                    'employee_id' => Arr::get($employee, 'id'),
                    'date' => $request->date,
                ]);

                if (! $attendance->is_time_based) {
                    $attendance->attendance_type_id = Arr::get($input, 'attendance_type_id');
                    $attendance->remarks = Arr::get($input, 'remarks');
                    $attendance->save();
                }
            }
        }

        Attendance::whereIn('employee_id', $employeesWithoutAttendance)->where('date', $request->date)->delete();
    }

    private function getAttendance(Request $request): Attendance
    {
        $attendance = Attendance::whereHas('employee', function ($q) use ($request) {
            $q->whereUuid($request->employee);
        })->where('date', $request->date)->first();

        if (! $attendance) {
            throw ValidationException::withMessages(['date' => trans('attendance.not_marked')]);
        }

        $payrollGenerated = Payroll::query()
            ->where('start_date', '<=', $attendance->date)
            ->where('end_date', '>=', $attendance->date)
            ->whereEmployeeId($attendance->employee_id)
            ->exists();

        $attendance->is_payroll_generated = $payrollGenerated;

        return $attendance;
    }

    public function fetchProduction(Request $request): array
    {
        $attendance = $this->getAttendance($request);

        $attendances = Record::whereAttendanceId($attendance->id)->get();

        $attendanceTypes = AttendanceType::byTeam()->productionBased()->get();

        $records = [];
        foreach ($attendanceTypes as $attendanceType) {
            $attendanceRecord = $attendances->firstWhere('attendance_type_id', $attendanceType->id);
            $records[] = [
                'attendance_type' => [
                    'uuid' => $attendanceType->uuid,
                    'name' => $attendanceType->name,
                    'code' => $attendanceType->code,
                    'unit_display' => AttendanceProductionUnit::getLabel($attendanceType->unit),
                    'category_display' => AttendanceCategory::getLabel($attendanceType->category),
                ],
                'value' => $attendanceRecord?->value ?? 0,
                'remarks' => $attendanceRecord?->remarks,
            ];
        }

        return $records;
    }

    public function markProduction(Request $request)
    {
        $attendance = $this->getAttendance($request);

        if ($attendance->is_payroll_generated) {
            throw ValidationException::withMessages(['message' => trans('attendance.could_not_perform_if_payroll_generated')]);
        }

        $attendanceTypes = $request->attendance_types;

        \DB::beginTransaction();

        foreach ($request->records as $record) {
            $attendanceRecord = Record::firstOrCreate([
                'attendance_id' => $attendance->id,
                'attendance_type_id' => $attendanceTypes->firstWhere('uuid', Arr::get($record, 'attendance_type.uuid'))->id,
            ]);

            $attendanceRecord->value = Arr::get($record, 'value', 0);
            $attendanceRecord->remarks = Arr::get($record, 'remarks');
            $attendanceRecord->save();
        }

        Record::whereAttendanceId($attendance->id)->where('value', 0)->delete();

        \DB::commit();
    }
}
