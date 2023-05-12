<?php

namespace App\Actions\Payroll;

use App\Enums\Payroll\PayHeadCategory;
use App\Models\Payroll\SalaryStructure;

class GetUserDefinedPayHeadRecord
{
    public function execute(SalaryStructure $salaryStructure, array $records = []): array
    {
        $salaryTemplate = $salaryStructure->template;

        foreach ($salaryTemplate->records->where('category', PayHeadCategory::USER_DEFINED->value)->sortBy('position') as $salaryTemplateRecord) {
            $records[] = [
                'pay_head' => [
                    'uuid' => $salaryTemplateRecord->payHead->uuid,
                    'name' => $salaryTemplateRecord->payHead->name,
                    'code' => $salaryTemplateRecord->payHead->code,
                    'type' => $salaryTemplateRecord->payHead->type,
                    'position' => $salaryTemplateRecord->position,
                    'is_user_defined' => $salaryTemplateRecord->is_user_defined,
                ],
                'amount' => 0,
            ];
        }

        return $records;
    }
}
