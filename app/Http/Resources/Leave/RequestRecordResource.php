<?php

namespace App\Http\Resources\Leave;

use App\Helpers\CalHelper;
use App\Http\Resources\UserSummaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestRecordResource extends JsonResource
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
            'request' => RequestResource::make($this->whenLoaded('request')),
            'approver' => UserSummaryResource::make($this->whenLoaded('approver')),
            'comment' => $this->comment,
            'status' => $this->status,
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }
}
