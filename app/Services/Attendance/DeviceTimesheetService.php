<?php

namespace App\Services\Attendance;

use App\Models\Attendance\Timesheet;
use App\Models\Device;
use App\Models\Employee\Employee;
use App\Models\Employee\WorkShift as EmployeeWorkShift;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DeviceTimesheetService
{
    public function store(Request $request)
    {
        if (! config('config.attendance.allow_employee_clock_in_out_via_device')) {
            throw ValidationException::withMessages(['message' => 'Attendance cannot be marked via device.', 'code' => 100]);
        }

        $device = Device::where('token', $request->token)->first();

        if (! $device) {
            throw ValidationException::withMessages(['message' => 'Invalid token.', 'code' => 101]);
        }

        $employee = Employee::query()
            ->whereCodeNumber($request->employee_code)
            ->where('joining_date', '<=', today()->toDateString())
            ->where(function ($q) {
                $q->whereNull('leaving_date')
                ->orWhere(function ($q) {
                    $q->whereNotNull('leaving_date')
                    ->where('leaving_date', '>=', today()->toDateString());
                });
            })
            ->first();

        if (! $employee) {
            throw ValidationException::withMessages(['message' => 'Invalid Employee code.', 'code' => 102]);
        }

        $employeeWorkShift = EmployeeWorkShift::query()
            ->select('work_shifts.records', 'employee_work_shifts.employee_id', 'employee_work_shifts.work_shift_id')
            ->join('work_shifts', function ($join) {
                $join->on('employee_work_shifts.work_shift_id', '=', 'work_shifts.id');
            })
            ->whereEmployeeId($employee->id)
            ->where('start_date', '<=', today()->toDateString())
            ->where('end_date', '>=', today()->toDateString())
            ->first();

        if (! $employeeWorkShift) {
            throw ValidationException::withMessages(['message' => 'Employee work shift not found.', 'code' => 103]);
        }

        $timesheet = Timesheet::query()
            ->whereEmployeeId($employee->id)
            ->where('date', today()->toDateString())
            ->orderBy('in_at', 'desc')
            ->first();

        if ($timesheet && ! $timesheet->out_at) {
            if ($timesheet->getMeta('device_id') != $device->id) {
                $meta = $timesheet->meta;
                $meta['out_device_id'] = $device->id;
                $meta['out_device_name'] = $device->name;
                $timesheet->meta = $meta;
            }

            $timesheet->out_at = now();
            $timesheet->save();
        } else {
            $timesheet = Timesheet::forceCreate([
                'employee_id' => $employee->id,
                'work_shift_id' => $employeeWorkShift->work_shift_id,
                'date' => today()->toDateString(),
                'in_at' => now()->toDateTimeString(),
                'meta' => [
                    'device_id' => $device->id,
                    'device_name' => $device->name,
                ],
            ]);
        }

        return ['message' => 'Attendance marked successfully.', 'code' => 200];

        // Do something
    }
}
