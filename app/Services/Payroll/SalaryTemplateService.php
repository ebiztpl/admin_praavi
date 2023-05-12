<?php

namespace App\Services\Payroll;

use App\Enums\Payroll\PayHeadCategory;
use App\Http\Resources\Attendance\TypeResource as AttendanceTypeResource;
use App\Http\Resources\Payroll\PayHeadResource;
use App\Models\Attendance\Type as AttendanceType;
use App\Models\Payroll\PayHead;
use App\Models\Payroll\SalaryStructure;
use App\Models\Payroll\SalaryTemplate;
use App\Models\Payroll\SalaryTemplateRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SalaryTemplateService
{
    public function preRequisite(Request $request): array
    {
        $payHeadCategories = PayHeadCategory::getOptions();

        $payHeads = PayHeadResource::collection(PayHead::byTeam()->get());

        $attendanceTypes = AttendanceTypeResource::collection(AttendanceType::byTeam()->productionBased()->get());

        return compact('payHeadCategories', 'payHeads', 'attendanceTypes');
    }

    public function create(Request $request): SalaryTemplate
    {
        \DB::beginTransaction();

        $salaryTemplate = SalaryTemplate::forceCreate($this->formatParams($request));

        $this->updateRecords($request, $salaryTemplate);

        \DB::commit();

        return $salaryTemplate;
    }

    private function formatParams(Request $request, ?SalaryTemplate $salaryTemplate = null): array
    {
        $formatted = [
            'name' => $request->name,
            'alias' => $request->alias,
            'description' => $request->description,
        ];

        if (! $salaryTemplate) {
            $formatted['team_id'] = session('team_id');
        }

        return $formatted;
    }

    private function updateRecords(Request $request, SalaryTemplate $salaryTemplate): void
    {
        $payHeadIds = [];
        foreach ($request->records as $index => $record) {
            $payHeadId = Arr::get($record, 'pay_head.id');
            $category = Arr::get($record, 'category');

            $salaryTemplateRecord = SalaryTemplateRecord::firstOrCreate([
                'salary_template_id' => $salaryTemplate->id,
                'pay_head_id' => $payHeadId,
            ]);

            $salaryTemplateRecord->uuid = $salaryTemplateRecord->uuid ?? (string) Str::uuid();
            $salaryTemplateRecord->position = $index;
            $salaryTemplateRecord->category = $category;
            $salaryTemplateRecord->computation = $category == PayHeadCategory::COMPUTATION->value ? Arr::get($record, 'computation') : null;
            $salaryTemplateRecord->attendance_type_id = Arr::get($record, 'attendance_type_id');
            $salaryTemplateRecord->save();

            $payHeadIds[] = $payHeadId;
        }

        SalaryTemplateRecord::whereSalaryTemplateId($salaryTemplate->id)->whereNotIn('pay_head_id', $payHeadIds)->delete();
    }

    private function ensureDoesntHaveSalaryStructure(SalaryTemplate $salaryTemplate): void
    {
        $salaryStructureExists = SalaryStructure::whereSalaryTemplateId($salaryTemplate->id)->exists();

        if ($salaryStructureExists) {
            throw ValidationException::withMessages(['message' => trans('global.associated_with_dependency', ['attribute' => trans('payroll.salary_template.salary_template'), 'dependency' => trans('payroll.salary_structure.salary_structure')])]);
        }
    }

    public function update(Request $request, SalaryTemplate $salaryTemplate): void
    {
        $this->ensureDoesntHaveSalaryStructure($salaryTemplate);

        \DB::beginTransaction();

        $salaryTemplate->forceFill($this->formatParams($request, $salaryTemplate))->save();

        $this->updateRecords($request, $salaryTemplate);

        \DB::commit();
    }

    public function deletable(SalaryTemplate $salaryTemplate): void
    {
        $this->ensureDoesntHaveSalaryStructure($salaryTemplate);
    }
}
