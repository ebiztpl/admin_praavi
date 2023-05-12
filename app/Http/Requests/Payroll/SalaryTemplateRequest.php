<?php

namespace App\Http\Requests\Payroll;

use App\Enums\Payroll\PayHeadCategory;
use App\Models\Attendance\Type as AttendanceType;
use App\Models\Payroll\PayHead;
use App\Models\Payroll\SalaryTemplate;
use App\Support\Evaluator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class SalaryTemplateRequest extends FormRequest
{
    use Evaluator;

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
            'name' => 'required|min:2|max:100',
            'alias' => 'nullable|min:2|max:100',
            'records' => 'array|required|min:1',
            'records.*.category' => ['required', new Enum(PayHeadCategory::class)],
            'description' => 'nullable|min:2|max:1000',
        ];
    }

    public function withValidator($validator)
    {
        if (! $validator->passes()) {
            return;
        }

        $validator->after(function ($validator) {
            $uuid = $this->route('salary_template.uuid');

            $existingNames = SalaryTemplate::query()
                ->byTeam()
                ->when($uuid, function ($q, $uuid) {
                    $q->where('uuid', '!=', $uuid);
                })
                ->whereName($this->name)
                ->exists();

            if ($existingNames) {
                $validator->errors()->add('name', trans('validation.unique', ['attribute' => __('payroll.salary_template.props.name')]));
            }

            $attendanceTypes = AttendanceType::byTeam()->productionBased()->get();
            $attendanceTypeUuids = $attendanceTypes->pluck('uuid')->all();

            $payHeads = PayHead::byTeam()->select('id', 'uuid', 'code')->get();
            $payHeadCodes = $payHeads->pluck('code')->all();
            $payHeadUuids = $payHeads->pluck('uuid')->all();

            $newRecords = [];
            $notApplicableCodes = [];
            foreach ($this->records as $index => $record) {
                $recordUuid = Arr::get($record, 'pay_head.uuid');
                $code = Arr::get($record, 'pay_head.code');
                $category = Arr::get($record, 'category');
                $computation = Arr::get($record, 'computation');
                $attendanceType = Arr::get($record, 'attendance_type.uuid');

                if ($category == 'not_applicable') {
                    $notApplicableCodes[] = $code;
                }

                if (! in_array($recordUuid, $payHeadUuids)) {
                    throw ValidationException::withMessages(['message' => trans('validation.exists', ['attribute' => trans('payroll.pay_head.pay_head')])]);
                }

                if ($category == PayHeadCategory::COMPUTATION->value) {
                    if (Str::of($computation)->contains('#'.$code.'#')) {
                        $validator->errors()->add('records.'.$index.'.computation', trans('payroll.salary_template.computation_contains_self_pay_head'));
                    }

                    foreach ($payHeadCodes as $payHeadCode) {
                        if (! in_array($payHeadCode, $notApplicableCodes)) {
                            $computation = str_replace('#'.$payHeadCode.'#', 1, $computation);
                        }
                    }

                    if ($this->evaluate($computation) === 'invalid') {
                        $validator->errors()->add('records.'.$index.'.computation', trans('validation.exists', ['attribute' => __('payroll.salary_template.props.computation')]));
                    }
                } elseif ($category == PayHeadCategory::PRODUCTION_BASED->value) {
                    if (! in_array($attendanceType, $attendanceTypeUuids)) {
                        $validator->errors()->add('records.'.$index.'.attendance_type', trans('validation.exists', ['attribute' => __('attendance.type.type')]));
                    }
                }

                $record['attendance_type_id'] = $attendanceTypes->firstWhere('uuid', $attendanceType)?->id;

                $newRecords[] = Arr::add($record, 'pay_head.id', $payHeads->firstWhere('uuid', $recordUuid)->id);
            }

            $this->merge(['records' => $newRecords]);

            if (! $this->alias) {
                return;
            }

            $existingAliases = SalaryTemplate::query()
                ->byTeam()
                ->when($uuid, function ($q, $uuid) {
                    $q->where('uuid', '!=', $uuid);
                })
                ->whereAlias($this->alias)
                ->exists();

            if ($existingAliases) {
                $validator->errors()->add('alias', trans('validation.unique', ['attribute' => __('payroll.salary_template.props.alias')]));
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
            'name' => __('payroll.salary_template.props.name'),
            'alias' => __('payroll.salary_template.props.alias'),
            'records.*.category' => __('payroll.salary_template.props.category'),
            'description' => __('payroll.salary_template.props.description'),
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
