<?php

namespace App\Actions\Payroll;

use App\Enums\Payroll\PayHeadCategory;
use App\Helpers\SysHelper;
use App\Models\Payroll\SalaryStructure;
use App\Support\Evaluator;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class GetComputationPayHeadRecord
{
    use Evaluator;

    public function execute(SalaryStructure $salaryStructure, array $records = []): array
    {
        $salaryTemplate = $salaryStructure->template;

        foreach ($salaryTemplate->records->where('category', PayHeadCategory::COMPUTATION->value)->sortBy('position') as $salaryTemplateRecord) {
            $computation = $salaryTemplateRecord->computation;
            foreach ($records as $record) {
                $computation = str_replace('#'.Arr::get($record, 'pay_head.code').'#', Arr::get($record, 'amount'), $computation);
            }

            $evaluation = $this->evaluate($computation);

            if ($evaluation === 'invalid') {
                throw ValidationException::withMessages(['message' => trans('payroll.salary_template.invalid_computation')]);
            }

            array_push($records, [
                'pay_head' => [
                    'uuid' => $salaryTemplateRecord->payHead->uuid,
                    'name' => $salaryTemplateRecord->payHead->name,
                    'code' => $salaryTemplateRecord->payHead->code,
                    'type' => $salaryTemplateRecord->payHead->type,
                    'position' => $salaryTemplateRecord->position,
                    'is_user_defined' => $salaryTemplateRecord->is_user_defined,
                ],
                'amount' => SysHelper::formatAmount($evaluation),
            ]);
        }

        return $records;
    }
}
