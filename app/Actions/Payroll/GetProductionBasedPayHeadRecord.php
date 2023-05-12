<?php

namespace App\Actions\Payroll;

use App\Enums\Payroll\PayHeadCategory;
use App\Helpers\SysHelper;
use App\Models\Payroll\SalaryStructure;
use Illuminate\Support\Collection;

class GetProductionBasedPayHeadRecord
{
    public function execute(SalaryStructure $salaryStructure, Collection $attendanceRecords, array $records = []): array
    {
        $salaryTemplate = $salaryStructure->template;

        foreach ($salaryTemplate->records->where('category', PayHeadCategory::PRODUCTION_BASED->value)->sortBy('position') as $salaryTemplateRecord) {
            $hourlySalary = $salaryStructure->records->firstWhere('pay_head_id', $salaryTemplateRecord->pay_head_id)->amount;

            $value = $attendanceRecords->where('attendance_type_id', $salaryTemplateRecord->attendance_type_id)->sum('value');

            $amount = SysHelper::formatAmount($value * $hourlySalary);

            $records[] = [
                'pay_head' => [
                    'uuid' => $salaryTemplateRecord->payHead->uuid,
                    'name' => $salaryTemplateRecord->payHead->name,
                    'code' => $salaryTemplateRecord->payHead->code,
                    'type' => $salaryTemplateRecord->payHead->type,
                    'position' => $salaryTemplateRecord->position,
                    'is_user_defined' => $salaryTemplateRecord->is_user_defined,
                ],
                'amount' => SysHelper::formatAmount($amount),
            ];
        }

        return $records;
    }
}
