<?php

namespace App\Http\Resources\Leave;

use App\Enums\Leave\RequestStatus;
use App\Helpers\CalHelper;
use App\Http\Resources\Employee\EmployeeSummaryResource;
use App\Http\Resources\Leave\TypeResource as LeaveTypeResource;
use App\Http\Resources\MediaResource;
use App\Http\Resources\UserSummaryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            'employee' => EmployeeSummaryResource::make($this->whenLoaded('employee')),
            'leave_type' => LeaveTypeResource::make($this->whenLoaded('type')),
            'requester' => UserSummaryResource::make($this->whenLoaded('requester')),
            'start_date' => CalHelper::toDate($this->start_date),
            'start_date_display' => CalHelper::showDate($this->start_date),
            'end_date' => CalHelper::toDate($this->end_date),
            'end_date_display' => CalHelper::showDate($this->end_date),
            'period' => $this->period,
            'duration' => $this->duration,
            'reason' => $this->reason,
            'comment' => $this->comment,
            'status' => $this->status,
            'status_detail' => RequestStatus::getDetail($this->status),
            'records' => RequestRecordResource::collection($this->whenLoaded('records')),
            'media_token' => $this->getMeta('media_token'),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }
}
