<?php

namespace App\Http\Resources\Payroll;

use App\Enums\Payroll\PayHeadType;
use App\Helpers\CalHelper;
use App\Http\Resources\TeamResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PayHeadResource extends JsonResource
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
            'alias' => $this->alias,
            'type' => $this->type,
            'type_display' => PayHeadType::getLabel($this->type),
            'type_detail' => PayHeadType::getDetail($this->type),
            'team' => TeamResource::make($this->whenLoaded('team')),
            'description' => $this->description,
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }
}
