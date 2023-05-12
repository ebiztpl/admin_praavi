<?php

namespace App\Http\Requests\Employee;

use App\Helpers\CalHelper;
use App\Models\Attendance\WorkShift as AttendanceWorkShift;
use App\Models\Employee\WorkShift;
use Illuminate\Foundation\Http\FormRequest;

class WorkShiftRequest extends FormRequest
{
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
        return [
            'work_shift' => 'required',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date',
            'remarks' => 'nullable|min:2|max:1000',
        ];
    }

    public function withValidator($validator)
    {
        if (! $validator->passes()) {
            return;
        }

        $validator->after(function ($validator) {
            $employeeUuid = $this->route('employee');
            $workShiftUuid = $this->route('work_shift');

            $workShift = AttendanceWorkShift::byTeam()->whereUuid($this->work_shift)->getOrFail(__('attendance.work_shift.work_shift'), 'work_shift');

            $existingWorkShift = WorkShift::query()
                ->whereHas('employee', function ($q) use ($employeeUuid) {
                    $q->whereUuid($employeeUuid);
                })
                ->whereOverlapping($this->start_date, $this->end_date)
                ->when($workShiftUuid, function ($q, $workShiftUuid) {
                    $q->where('uuid', '!=', $workShiftUuid);
                })
                ->exists();

            if ($existingWorkShift) {
                $validator->errors()->add('work_shift', trans('attendance.work_shift.range_exists', ['start' => CalHelper::showDate($this->start_date), 'end' => CalHelper::showDate($this->end_date)]));
            }

            $this->merge([
                'work_shift_id' => $workShift->id,
            ]);
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
            'work_shift' => __('attendance.work_shift.work_shift'),
            'start_date' => __('attendance.work_shift.props.start_date'),
            'end_date' => __('attendance.work_shift.props.end_date'),
            'remarks' => __('attendance.work_shift.props.remarks'),
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
