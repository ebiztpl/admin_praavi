<?php

namespace App\Services\Attendance;

use App\Concerns\SubordinateAccess;
use App\Enums\Attendance\TimesheetStatus;
use App\Helpers\CalHelper;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\Timesheet;
use App\Models\Attendance\Type as AttendanceType;
use App\Models\Calendar\Holiday;
use App\Models\Employee\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TimesheetSyncService
{
    use SubordinateAccess;

    const MAX_SYNC_COUNT = 1000;

    public function sync(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date',
        ]);

        $accessibleEmployeeIds = $this->getAccessibleEmployee();

        $employees = Str::toArray($request->query('employees'));

        $employeeIds = Employee::query()
            ->whereIn('id', $accessibleEmployeeIds)
            ->when($employees, function ($q) use ($employees) {
                $q->whereIn('uuid', $employees);
            })
            ->pluck('id')
            ->all();

        $timesheets = Timesheet::query()
            ->with(['workShift'])
            ->whereIn('employee_id', $employeeIds)
            ->whereNull('status')
            ->filter([
                'App\QueryFilters\DateBetween:start_date,end_date,date',
            ])->get();

        if ($timesheets->count() > self::MAX_SYNC_COUNT) {
            throw ValidationException::withMessages(['message' => trans('attendance.timesheet.max_sync_count_limit_exceed')]);
        }

        $attendanceTypes = AttendanceType::byTeam()->get()->map(function ($type) {
            return [
                'type' => $type->category,
                'id' => $type->id,
            ];
        })->toArray();

        $holidays = Holiday::query()
            ->whereOverlapping($request->start_date, $request->end_date)
            ->get();

        $date = Carbon::parse($request->start_date);

        while ($date <= Carbon::parse($request->end_date)) {
            $dateWiseTimesheets = $timesheets->where('date', $date->toDateString());

            $isHoliday = $holidays->where('start_date', '<=', $date->toDateString())
                ->where('end_date', '>=', $date->toDateString())
                ->first() ? true : false;

            foreach ($employeeIds as $employeeId) {
                $employeeTimesheets = $dateWiseTimesheets->where('employee_id', $employeeId)->sortBy('in_at');

                $attendance = Attendance::query()
                    ->whereEmployeeId($employeeId)
                    ->where('date', $date->toDateString())
                    ->first();

                \DB::beginTransaction();

                $this->checkIfAttendanceExists(
                    attendance: $attendance,
                    date: $date,
                    employeeId: $employeeId
                );

                $this->markAttendance(
                    attendance: $attendance,
                    employeeTimesheets: $employeeTimesheets,
                    date: $date,
                    attendanceTypes: $attendanceTypes,
                    employeeId: $employeeId,
                    isHoliday: $isHoliday
                );

                \DB::commit();
            }

            $date->addDay(1);
        }
    }

    private function checkIfAttendanceExists(?Attendance $attendance, Carbon $date, int $employeeId)
    {
        if (! $attendance) {
            return;
        }

        return Timesheet::query()
            ->whereEmployeeId($employeeId)
            ->where('date', $date->toDateString())
            ->whereNull('status')
            ->update([
                'status' => $attendance->is_time_based
                    ? TimesheetStatus::ALREADY_SYNCHED
                    : TimesheetStatus::MANUAL_ATTENDANCE,
            ]);
    }

    private function markAttendance(?Attendance $attendance, Collection $employeeTimesheets, Carbon $date, array $attendanceTypes, int $employeeId, bool $isHoliday)
    {
        if ($attendance) {
            return;
        }

        if ($employeeTimesheets->count()) {
            return $this->markAttendanceIfTimesheetExists(
                employeeTimesheets: $employeeTimesheets,
                date: $date,
                attendanceTypes: $attendanceTypes,
                employeeId: $employeeId
            );
        }

        return $this->markAttendanceIfTimesheetDoesntExist(
            date: $date,
            attendanceTypes: $attendanceTypes,
            employeeId: $employeeId,
            isHoliday: $isHoliday
        );
    }

    private function markAttendanceIfTimesheetExists(Collection $employeeTimesheets, Carbon $date, array $attendanceTypes, int $employeeId)
    {
        $employeeWorkShiftRecord = $this->findEmployeeWorkShiftRecord(
            employeeTimesheets: $employeeTimesheets,
            date: $date
        );

        if (! $employeeWorkShiftRecord) {
            return;
        }

        $this->markAsHolidayIfWorkShiftRecordIsHoliday(
            date: $date,
            employeeWorkShiftRecord: $employeeWorkShiftRecord,
            attendanceTypes: $attendanceTypes,
            employeeId: $employeeId
        );

        $this->markAttendanceIfWorkShiftRecordIsNotHoliday(
            employeeTimesheets: $employeeTimesheets,
            date: $date,
            employeeWorkShiftRecord: $employeeWorkShiftRecord,
            attendanceTypes: $attendanceTypes,
            employeeId: $employeeId
        );
    }

    private function markAsHolidayIfWorkShiftRecordIsHoliday(Carbon $date, array $employeeWorkShiftRecord, array $attendanceTypes, int $employeeId)
    {
        if (! Arr::get($employeeWorkShiftRecord, 'is_holiday')) {
            return;
        }

        $this->markAsPresent(
            date: $date,
            attendanceTypes: $attendanceTypes,
            employeeId: $employeeId
        );
    }

    private function markAttendanceIfWorkShiftRecordIsNotHoliday(Collection $employeeTimesheets, Carbon $date, array $employeeWorkShiftRecord, array $attendanceTypes, int $employeeId)
    {
        if (Arr::get($employeeWorkShiftRecord, 'is_holiday')) {
            return;
        }

        $startTime = CalHelper::storeDateTime($date->toDateString().' '.Arr::get($employeeWorkShiftRecord, 'start_time'));
        $endTime = CalHelper::storeDateTime($date->toDateString().' '.Arr::get($employeeWorkShiftRecord, 'end_time'));

        $totalShiftDuration = $endTime->diffInMinutes($startTime);

        $firstInTime = Carbon::parse($employeeTimesheets->first()->in_at);
        $lastOutTime = Carbon::parse($employeeTimesheets->last()->out_at);

        $totalWorkDuration = 0;
        foreach ($employeeTimesheets as $employeeTimesheet) {
            $totalWorkDuration += Carbon::parse($employeeTimesheet->out_at)->diffInMinutes($employeeTimesheet->in_at);
        }

        if ($totalWorkDuration >= $totalShiftDuration) {
            $attendance = $this->markAsPresent(
                date: $date,
                attendanceTypes: $attendanceTypes,
                employeeId: $employeeId
            );
        } elseif ($totalWorkDuration < $totalShiftDuration && $totalWorkDuration > ($totalShiftDuration / 2)) {
            $attendance = $this->markAsHalfDay(
                date: $date,
                attendanceTypes: $attendanceTypes,
                employeeId: $employeeId
            );
        } elseif ($totalWorkDuration < ($totalShiftDuration / 2)) {
            $attendance = $this->markAsAbsent(
                date: $date,
                attendanceTypes: $attendanceTypes,
                employeeId: $employeeId
            );
        }

        if ($attendance) {
            Timesheet::query()
                ->whereEmployeeId($employeeId)
                ->where('date', $date)
                ->update(['status' => TimesheetStatus::OK]);
        } else {
            Timesheet::query()
                ->whereEmployeeId($employeeId)
                ->where('date', $date)
                ->update(['status' => TimesheetStatus::OK]);
        }
    }

    private function markAttendanceIfTimesheetDoesntExist(Carbon $date, array $attendanceTypes, int $employeeId, bool $isHoliday)
    {
        if ($isHoliday) {
            return $this->markAsHoliday(
                date: $date,
                attendanceTypes: $attendanceTypes,
                employeeId: $employeeId,
            );
        }

        return $this->markAsAbsent(
            date: $date,
            attendanceTypes: $attendanceTypes,
            employeeId: $employeeId,
        );
    }

    private function markAsPresent(Carbon $date, array $attendanceTypes, int $employeeId): ?Attendance
    {
        $attendanceTypeId = $this->getAttendanceTypeId($attendanceTypes, 'present');

        if (! $attendanceTypeId) {
            return null;
        }

        return Attendance::forceCreate([
            'employee_id' => $employeeId,
            'date' => $date->toDateString(),
            'attendance_type_id' => $attendanceTypeId,
            'is_time_based' => true,
        ]);
    }

    private function markAsHalfDay(Carbon $date, array $attendanceTypes, int $employeeId): ?Attendance
    {
        $attendanceTypeId = $this->getAttendanceTypeId($attendanceTypes, 'half_day');

        if (! $attendanceTypeId) {
            return null;
        }

        return Attendance::forceCreate([
            'employee_id' => $employeeId,
            'date' => $date->toDateString(),
            'attendance_type_id' => $attendanceTypeId,
            'is_time_based' => true,
        ]);
    }

    private function markAsHoliday(Carbon $date, array $attendanceTypes, int $employeeId): ?Attendance
    {
        $attendanceTypeId = $this->getAttendanceTypeId($attendanceTypes, 'holiday');

        if (! $attendanceTypeId) {
            return null;
        }

        return Attendance::forceCreate([
            'employee_id' => $employeeId,
            'date' => $date->toDateString(),
            'attendance_type_id' => $attendanceTypeId,
            'is_time_based' => true,
        ]);
    }

    private function markAsAbsent(Carbon $date, array $attendanceTypes, int $employeeId): ?Attendance
    {
        if ($date->toDateString() > today()->toDateString()) {
            return null;
        }

        $attendanceTypeId = $this->getAttendanceTypeId($attendanceTypes, 'absent');

        if (! $attendanceTypeId) {
            return null;
        }

        return Attendance::forceCreate([
            'employee_id' => $employeeId,
            'date' => $date->toDateString(),
            'attendance_type_id' => $attendanceTypeId,
            'is_time_based' => true,
        ]);
    }

    private function getAttendanceTypeId(array $attendanceTypes, string $attendanceType)
    {
        $type = Arr::first($attendanceTypes, function ($item) use ($attendanceType) {
            return Arr::get($item, 'type') == $attendanceType;
        });

        return Arr::get($type, 'id');
    }

    private function findEmployeeWorkShiftRecord(Collection $employeeTimesheets, Carbon $date)
    {
        $employeeWorkShift = $employeeTimesheets->first()?->workShift;

        if (! $employeeWorkShift) {
            return;
        }

        return Arr::first($employeeWorkShift->records, function ($item) use ($date) {
            return Arr::get($item, 'day') == strtolower($date->englishDayOfWeek);
        });
    }
}
