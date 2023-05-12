<?php

namespace App\Http\Resources\Attendance;

use App\Enums\Day;
use App\Helpers\CalHelper;
use App\Http\Resources\TeamResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

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
            'name' => $this->name,
            'code' => $this->code,
            'records' => $this->getRecords(),
            'description' => $this->description,
            'team' => TeamResource::make($this->whenLoaded('team')),
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }

    private function getRecords(): array
    {
        $records = [];

        foreach ($this->records as $record) {
            $records[] = [
                ...$record,
                'label' => Day::getLabel(Arr::get($record, 'day')),
                'start_time_display' => CalHelper::showTime(Arr::get($record, 'start_time')),
                'end_time_display' => CalHelper::showTime(Arr::get($record, 'end_time')),
            ];
        }

        return $records;
    }
}
