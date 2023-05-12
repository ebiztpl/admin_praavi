<?php

namespace App\Http\Resources\Payroll;

use App\Helpers\CalHelper;
use App\Helpers\SysHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
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
            'calculated' => SysHelper::formatAmount($this->calculated),
            'calculated' => SysHelper::formatCurrency($this->calculated),
            'amount' => SysHelper::formatAmount($this->amount),
            'amount_display' => SysHelper::formatCurrency($this->amount),
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }
}
