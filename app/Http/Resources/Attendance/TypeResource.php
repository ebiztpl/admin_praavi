<?php

namespace App\Http\Resources\Attendance;

use App\Enums\Attendance\Category as AttendanceCategory;
use App\Enums\Attendance\ProductionUnit as AttendanceProductionUnit;
use App\Helpers\CalHelper;
use App\Http\Resources\TeamResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'unit' => $this->unit,
            'unit_display' => AttendanceProductionUnit::getLabel($this->unit),
            'unit_detail' => AttendanceProductionUnit::getDetail($this->unit),
            'category' => $this->category,
            'category_display' => AttendanceCategory::getLabel($this->category),
            'category_detail' => AttendanceCategory::getDetail($this->category),
            'alias' => $this->alias,
            'team' => TeamResource::make($this->whenLoaded('team')),
            'description' => $this->description,
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }
}
