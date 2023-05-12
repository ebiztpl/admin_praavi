<?php

namespace App\Http\Resources\Employee;

use App\Helpers\CalHelper;
use App\Http\Resources\Attendance\WorkShiftResource as AttendanceWorkShiftResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkShiftResource extends JsonResource
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
            'work_shift' => AttendanceWorkShiftResource::make($this->whenLoaded('workShift')),
            'start_date' => CalHelper::toDate($this->start_date),
            'start_date_display' => CalHelper::showDate($this->start_date),
            'end_date' => CalHelper::toDate($this->end_date),
            'end_date_display' => CalHelper::showDate($this->end_date),
            'period' => CalHelper::getPeriod($this->start_date, $this->end_date),
            'duration' => CalHelper::getDuration($this->start_date, $this->end_date),
            'remarks' => $this->remarks,
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }
}
