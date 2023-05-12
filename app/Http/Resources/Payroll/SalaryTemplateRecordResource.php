<?php

namespace App\Http\Resources\Payroll;

use App\Enums\Attendance\ProductionUnit as AttendanceProductionUnit;
use App\Enums\Payroll\PayHeadCategory;
use App\Enums\Payroll\SalaryStructureUnit;
use App\Helpers\CalHelper;
use App\Http\Resources\Attendance\TypeResource as AttendanceTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryTemplateRecordResource extends JsonResource
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
            'pay_head' => PayHeadResource::make($this->whenLoaded('payHead')),
            'attendance_type' => AttendanceTypeResource::make($this->whenLoaded('attendanceType')),
            'category' => $this->category,
            'category_display' => PayHeadCategory::getLabel($this->category),
            'category_detail' => PayHeadCategory::getDetail($this->category),
            $this->mergeWhen($this->category != PayHeadCategory::PRODUCTION_BASED->value, [
                'unit' => SalaryStructureUnit::getDetail('monthly'),
            ]),
            $this->mergeWhen($this->category == PayHeadCategory::PRODUCTION_BASED->value, [
                'unit' => AttendanceProductionUnit::getDetail('hourly'),
            ]),
            'enable_user_input' => $this->enable_user_input,
            'position' => $this->position,
            'computation' => $this->computation,
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }
}
