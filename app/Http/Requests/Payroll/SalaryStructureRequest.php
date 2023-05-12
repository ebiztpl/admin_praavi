<?php

namespace App\Http\Requests\Payroll;

use App\Concerns\SubordinateAccess;
use App\Enums\Payroll\PayHeadCategory;
use App\Enums\Payroll\PayHeadType;
use App\Models\Employee\Employee;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\SalaryStructure;
use App\Models\Payroll\SalaryTemplate;
use App\Support\Evaluator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class SalaryStructureRequest extends FormRequest
{
    use SubordinateAccess, Evaluator;

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
            'employee' => 'required|uuid',
            'salary_template' => 'required|uuid',
            'effective_date' => 'required|date',
            'records' => 'required|array',
            'records.*.amount' => 'required|numeric|min:0',
            'description' => 'nullable|min:2|max:1000',
        ];
    }

    public function withValidator($validator)
    {
        if (! $validator->passes()) {
            return;
        }

        $validator->after(function ($validator) {
            $uuid = $this->route('salary_structure');

            $employee = Employee::byTeam()->whereUuid($this->employee)->getOrFail(trans('employee.employee'), 'employee');

            $this->validateAccessibleEmployee($employee);

            $this->validateEmployeeJoiningDate($employee, $this->effective_date, trans('payroll.salary_structure.props.effective_date'), 'effective_date');

            $this->validateEmployeeLeavingDate($employee, $this->effective_date, trans('payroll.salary_structure.props.effective_date'), 'effective_date');

            $salaryTemplate = SalaryTemplate::with('records', 'records.payHead')->byTeam()->whereUuid($this->salary_template)->getOrFail('payroll.salary_template.salary_template', 'salary_template');

            $backwardSalaryStructure = SalaryStructure::query()
                ->whereEmployeeId($employee->id)
                ->where('effective_date', '>=', $this->effective_date)
                ->when($uuid, function ($q, $uuid) {
                    $q->where('uuid', '!=', $uuid);
                })
                ->exists();

            if ($backwardSalaryStructure) {
                $validator->errors()->add('employee', trans('payroll.salary_structure.could_not_perform_if_defined_for_later_date'));
            }

            $payrollExists = Payroll::query()
                ->whereEmployeeId($employee->id)
                ->where('start_date', '<=', $this->effective_date)
                ->when($uuid, function ($q, $uuid) {
                    $q->where('uuid', '!=', $uuid);
                })
                ->exists();

            if ($payrollExists) {
                $validator->errors()->add('effective_date', trans('payroll.salary_structure.could_not_perform_if_payroll_generated'));
            }

            $salaryTemplateRecords = $salaryTemplate->records->filter(function ($record) {
                return in_array($record->category, PayHeadCategory::userInput());
            });
            $payHeadUuids = $salaryTemplateRecords->pluck('payHead.uuid')->all();

            $newRecords = [];
            $payHeads = [];
            $netEarning = 0;
            $netDeduction = 0;
            $netSalary = 0;

            foreach ($this->records as $index => $record) {
                $uuid = Arr::get($record, 'pay_head.uuid');

                if (! in_array($uuid, $payHeadUuids)) {
                    throw ValidationException::withMessages(['message' => trans('validation.exists', ['attribute' => trans('payroll.pay_head.pay_head')])]);
                }

                $salaryTemplateRecord = $salaryTemplateRecords->firstWhere('payHead.uuid', $uuid);

                $amount = Arr::get($record, 'amount', 0);
                $payHeads[$salaryTemplateRecord->payHead->code] = $amount;

                if ($salaryTemplateRecord->payHead->type == PayHeadType::EARNING->value) {
                    $netEarning += $amount;
                } else {
                    $netDeduction += $amount;
                }

                $newRecord = Arr::add($record, 'id', $salaryTemplateRecord->pay_head_id);
                $newRecord = Arr::add($newRecord, 'category', $salaryTemplateRecord->category);
                $newRecords[] = $newRecord;
            }

            $computedSalaryTemplateRecords = $salaryTemplate->records->filter(function ($record) {
                return in_array($record->category, [PayHeadCategory::COMPUTATION->value]);
            })->sortBy('position');

            foreach ($computedSalaryTemplateRecords as $record) {
                $computation = $record->computation;
                foreach ($payHeads as $code => $value) {
                    $computation = str_replace('#'.$code.'#', $value, $computation);
                }

                $evaluation = $this->evaluate($computation);

                if ($evaluation === 'invalid') {
                    throw ValidationException::withMessages(['message' => trans('payroll.salary_template.invalid_computation')]);
                }

                $payHeads[$record->payHead->code] = $evaluation;

                if ($record->payHead->type == PayHeadType::EARNING->value) {
                    $netEarning += $evaluation;
                } else {
                    $netDeduction += $evaluation;
                }
            }

            $netSalary = $netEarning - $netDeduction;

            if ($netSalary < 0) {
                throw ValidationException::withMessages(['message' => trans('validation.min.numeric', ['attribute' => trans('payroll.salary_structure.props.net_salary'), 'min' => 0])]);
            }

            $this->merge([
                'employee_id' => $employee->id,
                'salary_template_id' => $salaryTemplate->id,
                'records' => $newRecords,
                'net_earning' => $netEarning,
                'net_deduction' => $netDeduction,
                'net_salary' => $netSalary,
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
            'employee' => __('employee.employee'),
            'salary_template' => __('payroll.salary_template.salary_template'),
            'effective_date' => __('payroll.salary_structure.props.effective_date'),
            'records.*.amount' => __('payroll.salary_structure.props.amount'),
            'description' => __('payroll.salary_structure.props.description'),
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
