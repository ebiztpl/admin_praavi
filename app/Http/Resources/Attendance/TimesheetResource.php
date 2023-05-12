<?php

namespace App\Http\Resources\Attendance;

use App\Enums\Attendance\TimesheetStatus;
use App\Helpers\CalHelper;
use App\Http\Resources\Employee\EmployeeSummaryResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TimesheetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $duration = '';

        if ($this->out_at) {
            $duration = Carbon::parse($this->out_at)->diff($this->in_at)->format('%H:%I:%S');
        }

        return [
            'uuid' => $this->uuid,
            'employee' => EmployeeSummaryResource::make($this->whenLoaded('employee')),
            'work_shift' => WorkShiftResource::make($this->whenLoaded('workShift')),
            'date' => CalHelper::toDate($this->date),
            'date_display' => CalHelper::showDate($this->date),
            'in_at' => CalHelper::toTime($this->in_at),
            'in_at_time_display' => CalHelper::showTime($this->in_at),
            'in_at_display' => CalHelper::showDateTime($this->in_at),
            'duration' => $duration,
            'clock_in' => $this->out_at ? true : false,
            'clock_out' => $this->out_at ? false : true,
            'out_at' => CalHelper::toTime($this->out_at),
            'out_at_time_display' => CalHelper::showTime($this->out_at),
            'out_at_display' => CalHelper::showDateTime($this->out_at),
            'is_manual' => $this->is_manual ? true : false,
            'is_synched' => $this->status ? true : false,
            'status' => $this->status,
            'status_detail' => TimesheetStatus::getDetail($this->status),
            'remarks' => $this->remarks,
            'is_editable' => $this->status ? false : true,
            'is_deletable' => $this->status ? false : true,
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }
}
