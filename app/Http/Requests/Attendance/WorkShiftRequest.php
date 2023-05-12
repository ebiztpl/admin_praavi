<?php

namespace App\Http\Requests\Attendance;

use App\Enums\Day;
use App\Models\Attendance\WorkShift;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

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
        $rules = [
            'name' => 'required|min:2|max:100',
            'code' => 'required|min:2|max:20',
            'records' => 'array',
            'records.*.is_holiday' => 'boolean',
            'records.*.start_time' => 'required_if:records.*.is_holiday,false|nullable|date_format:H:i:s',
            'records.*.end_time' => 'required_if:records.*.is_holiday,false|nullable|date_format:H:i:s',
            'description' => 'nullable|min:2|max:1000',
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
        if (! $validator->passes()) {
            return;
        }

        $validator->after(function ($validator) {
            $uuid = $this->route('work_shift.uuid');

            $existingNames = WorkShift::query()
                ->byTeam()
                ->when($uuid, function ($q, $uuid) {
                    $q->where('uuid', '!=', $uuid);
                })
                ->whereName($this->name)
                ->exists();

            if ($existingNames) {
                $validator->errors()->add('name', trans('validation.unique', ['attribute' => __('attendance.work_shift.props.name')]));
            }

            $existingCodes = WorkShift::query()
                ->byTeam()
                ->when($uuid, function ($q, $uuid) {
                    $q->where('uuid', '!=', $uuid);
                })
                ->whereCode($this->code)
                ->exists();

            if ($existingCodes) {
                $validator->errors()->add('code', trans('validation.unique', ['attribute' => __('attendance.work_shift.props.code')]));
            }

            $days = Day::getKeys();
            $daysInput = [];
            $records = [];

            foreach ($this->records as $index => $record) {
                $daysInput[] = Arr::get($record, 'day');
                $isHoliday = (bool) Arr::get($record, 'is_holiday');
                $startTime = Arr::get($record, 'start_time');
                $endTime = Arr::get($record, 'end_time');

                if (! $isHoliday && $startTime >= $endTime) {
                    $validator->errors()->add("records.{$index}.start_time", __('attendance.work_shift.start_time_should_less_than_end_time'));
                }

                $records[] = [
                    'day' => Arr::get($record, 'day'),
                    'is_holiday' => $isHoliday,
                    'start_time' => ! $isHoliday ? $startTime : null,
                    'end_time' => ! $isHoliday ? $endTime : null,
                ];
            }

            if (array_diff($days, $daysInput)) {
                $validator->errors()->add('records', __('attendance.work_shift.all_days_should_be_filled'));
            }

            $this->merge(['records' => $records]);
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
            'name' => __('attendance.work_shift.props.name'),
            'code' => __('attendance.work_shift.props.code'),
            'records.*.is_holiday' => __('attendance.work_shift.props.holiday'),
            'records.*.start_time' => __('attendance.work_shift.props.start_time'),
            'records.*.end_time' => __('attendance.work_shift.props.end_time'),
            'description' => __('company.department.props.description'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'records.*.start_time.required_if' => __('validation.required', ['attribute' => __('attendance.work_shift.props.start_time')]),
            'records.*.end_time.required_if' => __('validation.required', ['attribute' => __('attendance.work_shift.props.end_time')]),
        ];
    }
}
