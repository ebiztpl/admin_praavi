<?php

namespace App\Http\Resources\Payroll;

use App\Enums\Payroll\SalaryStructureUnit;
use App\Helpers\CalHelper;
use App\Helpers\SysHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryStructureRecordResource extends JsonResource
{
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
            'unit' => $this->unit,
            'unit_display' => SalaryStructureUnit::getLabel($this->unit),
            'unit_detail' => SalaryStructureUnit::getDetail($this->unit),
            'amount' => SysHelper::formatAmount($this->amount),
            'amount_display' => SysHelper::formatCurrency($this->amount),
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }
}
