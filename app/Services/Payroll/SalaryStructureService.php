<?php

namespace App\Services\Payroll;

use App\Enums\Attendance\ProductionUnit as AttendanceProductionUnit;
use App\Enums\Payroll\PayHeadCategory;
use App\Enums\Payroll\SalaryStructureUnit;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\SalaryStructure;
use App\Models\Payroll\SalaryStructureRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SalaryStructureService
{
    public function preRequisite(Request $request): array
    {
        return [];
    }

    public function create(Request $request): SalaryStructure
    {
        \DB::beginTransaction();

        $salaryStructure = SalaryStructure::forceCreate($this->formatParams($request));

        $this->updateRecords($request, $salaryStructure);

        \DB::commit();

        return $salaryStructure;
    }

    private function formatParams(Request $request, ?SalaryStructure $salaryStructure = null): array
    {
        $formatted = [
            'employee_id' => $request->employee_id,
            'salary_template_id' => $request->salary_template_id,
            'effective_date' => $request->effective_date,
            'net_earning' => $request->net_earning,
            'net_deduction' => $request->net_deduction,
            'net_salary' => $request->net_salary,
            'description' => $request->description,
        ];

        if (! $salaryStructure) {
        }

        return $formatted;
    }

    private function updateRecords(Request $request, SalaryStructure $salaryStructure): void
    {
        $payHeadIds = [];
        foreach ($request->records as $index => $record) {
            $payHeadId = Arr::get($record, 'id');
            $amount = Arr::get($record, 'amount', 0);

            $salaryStructureRecord = SalaryStructureRecord::firstOrCreate([
                'salary_structure_id' => $salaryStructure->id,
                'pay_head_id' => $payHeadId,
            ]);

            $salaryStructureRecord->uuid = $salaryStructureRecord->uuid ?? (string) Str::uuid();
            $salaryStructureRecord->amount = $amount;
            $salaryStructureRecord->unit = Arr::get($record, 'category') == PayHeadCategory::PRODUCTION_BASED->value ? AttendanceProductionUnit::HOURLY->value : SalaryStructureUnit::MONTHLY->value;
            $salaryStructureRecord->save();

            $payHeadIds[] = $payHeadId;
        }

        SalaryStructureRecord::whereSalaryStructureId($salaryStructure->id)->whereNotIn('pay_head_id', $payHeadIds)->delete();
    }

    private function ensureDoesntHavePayroll(SalaryStructure $salaryStructure): void
    {
        $payrollExists = Payroll::whereSalaryStructureId($salaryStructure->id)->exists();

        if ($payrollExists) {
            throw ValidationException::withMessages(['message' => trans('global.associated_with_dependency', ['attribute' => trans('payroll.salary_structure.salary_structure'), 'dependency' => trans('payroll.payroll')])]);
        }
    }

    public function update(Request $request, SalaryStructure $salaryStructure): void
    {
        $this->ensureDoesntHavePayroll($salaryStructure);

        \DB::beginTransaction();

        $salaryStructure->forceFill($this->formatParams($request, $salaryStructure))->save();

        $this->updateRecords($request, $salaryStructure);

        \DB::commit();
    }

    public function deletable(SalaryStructure $salaryStructure): void
    {
        $this->ensureDoesntHavePayroll($salaryStructure);
    }
}
