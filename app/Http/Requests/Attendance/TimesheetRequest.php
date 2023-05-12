<?php

namespace App\Http\Requests\Attendance;

use App\Concerns\SubordinateAccess;
use App\Helpers\CalHelper;
use App\Models\Attendance\Timesheet;
use App\Models\Employee\Employee;
use App\Models\Employee\WorkShift as EmployeeWorkShift;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TimesheetRequest extends FormRequest
{
    use SubordinateAccess;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'employee' => 'required',
            'date' => 'required|date',
            'in_at' => 'required|date_format:H:i:s',
            'out_at' => 'nullable|date_format:H:i:s',
            'remarks' => 'nullable|min:2|max:1000',
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
        if (! $validator->passes()) {
            return;
        }

        $validator->after(function ($validator) {
            $uuid = $this->route('timesheet');

            $employee = Employee::findWithDetailOrFail($this->employee, 'employee');

            $this->validateAccessibleEmployee($employee, false);

            $this->validateEmployeeJoiningDate($employee, $this->date, trans('employee.employee'), 'employee');
            $this->validateEmployeeLeavingDate($employee, $this->date, trans('employee.employee'), 'employee');

            $employeeWorkShift = EmployeeWorkShift::query()
                ->select('work_shifts.name', 'work_shifts.code', 'work_shifts.records', 'employee_work_shifts.start_date', 'employee_work_shifts.end_date', 'employee_work_shifts.employee_id', 'employee_work_shifts.work_shift_id')
                ->join('work_shifts', function ($join) {
                    $join->on('employee_work_shifts.work_shift_id', '=', 'work_shifts.id');
                })
                ->whereEmployeeId($employee->id)
                ->where('start_date', '<=', $this->date)
                ->where('end_date', '>=', $this->date)
                ->first();

            if (! $employeeWorkShift) {
                $validator->errors()->add('employee', trans('attendance.timesheet.could_not_perform_without_work_shift'));
            }

            if ($this->out_at && Carbon::parse($this->in_at) > Carbon::parse($this->out_at)) {
                $validator->errors()->add('in_at', trans('attendance.timesheet.start_time_should_less_than_end_time'));
            }

            $timesheetWithEmptyOutAt = TimeSheet::query()
                ->when($uuid, function ($query) use ($uuid) {
                    $query->where('uuid', '!=', $uuid);
                })
                ->whereEmployeeId($employee->id)
                ->where('date', $this->date)
                ->whereNull('out_at')
                ->exists();

            if ($timesheetWithEmptyOutAt) {
                $validator->errors()->add('in_at', trans('attendance.timesheet.could_not_perform_if_empty_out_at'));
            }

            $date = $this->date;

            $this->merge([
                'employee_id' => $employee->id,
                'work_shift_id' => $employeeWorkShift?->work_shift_id,
                'in_at' => CalHelper::storeDateTime($date.' '.$this->in_at)->toDateTimeString(),
                'out_at' => $this->out_at ? CalHelper::storeDateTime($date.' '.$this->out_at)->toDateTimeString() : null,
            ]);

            if ($this->out_at) {
                $overlappingTimesheet = Timesheet::query()
                    ->when($uuid, function ($query) use ($uuid) {
                        $query->where('uuid', '!=', $uuid);
                    })
                    ->whereEmployeeId($employee->id)
                    ->where('date', $this->date)
                    ->where(function ($q) {
                        $q->where(function ($q) {
                            $q->where('in_at', '<=', $this->in_at)->where('out_at', '>=', $this->in_at);
                        })->orWhere(function ($q) {
                            $q->where('in_at', '<=', $this->out_at)->where('out_at', '>=', $this->out_at);
                        })->orWhere(function ($q) {
                            $q->where('in_at', '>=', $this->in_at)->where('out_at', '<=', $this->out_at);
                        });
                    })->exists();
            } else {
                $overlappingTimesheet = Timesheet::query()
                    ->when($uuid, function ($query) use ($uuid) {
                        $query->where('uuid', '!=', $uuid);
                    })
                    ->whereEmployeeId($employee->id)
                    ->where('date', $this->date)
                    ->where('in_at', '<=', $this->in_at)->where('out_at', '>=', $this->in_at)
                    ->exists();
            }

            if ($overlappingTimesheet) {
                $validator->errors()->add('in_at', trans('attendance.timesheet.range_exists', ['start' => CalHelper::showTime($this->in_at), 'end' => CalHelper::showTime($this->out_at)]));
            }
        });
    }

    /**
     * Translate fields with user friendly name.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'employee' => __('employee.employee'),
            'date' => __('attendance.timesheet.props.date'),
            'in_at' => __('attendance.timesheet.props.in_at'),
            'out_at' => __('attendance.timesheet.props.out_at'),
            'remarks' => __('attendance.timesheet.props.remarks'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
