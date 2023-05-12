<?php

namespace App\Http\Resources\Payroll;

use App\Enums\Payroll\PayHeadCategory;
use App\Enums\Payroll\PayHeadType;
use App\Helpers\CalHelper;
use App\Helpers\SysHelper;
use App\Http\Resources\Employee\EmployeeSummaryResource;
use App\Support\Evaluator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class SalaryStructureResource extends JsonResource
{
    use Evaluator;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'employee' => EmployeeSummaryResource::make($this->whenLoaded('employee')),
            'effective_date' => CalHelper::toDate($this->effective_date),
            'effective_date_display' => CalHelper::showDate($this->effective_date),
            'template' => SalaryTemplateResource::make($this->whenLoaded('template')),
            $this->mergeWhen($this->relationLoaded('records'), [
                'records' => $this->getRecords($request),
            ]),
            'net_earning' => SysHelper::formatAmount($this->net_earning),
            'net_earning_display' => SysHelper::formatCurrency($this->net_earning),
            'net_deduction' => SysHelper::formatAmount($this->net_deduction),
            'net_deduction_display' => SysHelper::formatCurrency($this->net_deduction),
            'net_salary' => SysHelper::formatAmount($this->net_salary),
            'net_salary_display' => SysHelper::formatCurrency($this->net_salary),
            'description' => $this->description,
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }

    private function getRecords($request)
    {
        if (! $request->show_record) {
            return [];
        }

        $salaryTemplate = $this->template;

        $payHeads = [];

        foreach ($this->records as $record) {
            $code = $salaryTemplate->records->firstWhere('pay_head_id', $record->pay_head_id)?->payHead?->code;
            $payHeads[$code] = SysHelper::formatAmount($record->amount);
        }

        $records = [];
        foreach ($salaryTemplate->records as $record) {
            $payHead = $record->payHead;

            if (in_array($record->category, PayHeadCategory::userInput())) {
                $amount = Arr::get($payHeads, $payHead->code, 0);
            } elseif ($record->category == PayHeadCategory::COMPUTATION->value) {
                $computation = $record->computation;
                foreach ($payHeads as $code => $value) {
                    $computation = str_replace('#'.$code.'#', $value, $computation);
                }

                $evaluation = $this->evaluate($computation);

                if ($evaluation === 'invalid') {
                    throw ValidationException::withMessages(['message' => trans('payroll.salary_template.invalid_computation')]);
                }

                $payHeads[$record->payHead->code] = $evaluation;

                $amount = $evaluation;
            } else {
                $amount = '-';
            }

            $records[] = [
                'uuid' => $record->uuid,
                'pay_head' => [
                    'uuid' => $payHead->uuid,
                    'name' => $payHead->name,
                    'code' => $payHead->code,
                    'type' => $payHead->type,
                    'type_display' => PayHeadType::getLabel($payHead->type),
                    'type_record' => PayHeadType::getDetail($payHead->type),
                ],
                'enable_user_input' => $record->enable_user_input,
                'category' => $record->category,
                'category_display' => PayHeadCategory::getLabel($record->category),
                'category_record' => PayHeadCategory::getDetail($record->category),
                'computation' => $record->computation,
                'amount' => SysHelper::formatAmount($amount),
                'amount_display' => SysHelper::formatCurrency($amount),
            ];
        }

        return $records;
    }
}
