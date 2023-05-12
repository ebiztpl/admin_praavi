<?php

namespace App\Actions\Payroll;

use App\Enums\Payroll\PayHeadCategory;
use App\Helpers\SysHelper;
use App\Models\Payroll\SalaryStructure;

class GetAttendanceBasedPayHeadRecord
{
    public function execute(SalaryStructure $salaryStructure, float $present = 0, array $records = []): array
    {
        $salaryTemplate = $salaryStructure->template;

        foreach ($salaryTemplate->records->where('category', PayHeadCategory::ATTENDANCE_BASED->value) as $salaryTemplateRecord) {
            $monthlySalary = $salaryStructure->records->firstWhere('pay_head_id', $salaryTemplateRecord->pay_head_id)->amount;

            $salary = SysHelper::formatAmount(($monthlySalary / 30) * ($present));

            array_push($records, [
                'pay_head' => [
                    'uuid' => $salaryTemplateRecord->payHead->uuid,
                    'name' => $salaryTemplateRecord->payHead->name,
                    'code' => $salaryTemplateRecord->payHead->code,
                    'type' => $salaryTemplateRecord->payHead->type,
                    'position' => $salaryTemplateRecord->position,
                    'is_user_defined' => $salaryTemplateRecord->is_user_defined,
                ],
                'amount' => $salary,
            ]);
        }

        return $records;
    }
}
