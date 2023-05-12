<?php

namespace App\Http\Resources\Payroll;

use App\Helpers\CalHelper;
use App\Http\Resources\TeamResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryTemplateResource extends JsonResource
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
            'alias' => $this->alias,
            'structures_count' => $this->structures_count,
            'team' => TeamResource::make($this->whenLoaded('team')),
            'records' => SalaryTemplateRecordResource::collection($this->whenLoaded('records')),
            'description' => $this->description,
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }
}
