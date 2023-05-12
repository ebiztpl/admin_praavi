<?php

namespace App\Http\Resources\Leave;

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
            'alias' => $this->alias,
            'team' => TeamResource::make($this->whenLoaded('team')),
            'description' => $this->description,
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }
}
