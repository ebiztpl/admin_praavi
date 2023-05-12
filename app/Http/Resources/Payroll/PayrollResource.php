<?php

namespace App\Http\Resources\Payroll;

use App\Enums\Finance\PaymentStatus;
use App\Helpers\CalHelper;
use App\Helpers\SysHelper;
use App\Http\Resources\Employee\EmployeeSummaryResource;
use App\Models\Attendance\Type as AttendanceType;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class PayrollResource extends JsonResource
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
            'code_number' => $this->code_number,
            'salary_structure' => SalaryStructureResource::make($this->whenLoaded('salaryStructure')),
            'employee' => EmployeeSummaryResource::make($this->whenLoaded('employee')),
            'start_date' => CalHelper::toDate($this->start_date),
            'start_date_display' => CalHelper::showDate($this->start_date),
            'end_date' => CalHelper::toDate($this->end_date),
            'end_date_display' => CalHelper::showDate($this->end_date),
            'period' => $this->period,
            'duration' => $this->duration,
            'total' => SysHelper::formatAmount($this->total),
            'total_display' => SysHelper::formatCurrency($this->total),
            'paid' => SysHelper::formatAmount($this->paid),
            'paid_display' => SysHelper::formatCurrency($this->paid),
            'is_paid' => $this->total > $this->paid ? false : true,
            'status' => $this->status,
            'status_display' => PaymentStatus::getLabel($this->status),
            'status_detail' => PaymentStatus::getDetail($this->status),
            'remarks' => $this->remarks,
            'net_earning' => SysHelper::formatAmount($this->getMeta('actual.earning')),
            'net_earning_display' => SysHelper::formatCurrency($this->getMeta('actual.earning')),
            'net_deduction' => SysHelper::formatAmount($this->getMeta('actual.deduction')),
            'net_deduction_display' => SysHelper::formatCurrency($this->getMeta('actual.deduction')),
            $this->mergeWhen($request->show_attendance_summary, [
                'attendances' => $this->getAttendanceSummary(),
            ]),
            'records' => RecordResource::collection($this->whenLoaded('records')),
            'created_at' => CalHelper::showDateTime($this->created_at),
            'updated_at' => CalHelper::showDateTime($this->updated_at),
        ];
    }

    private function getAttendanceSummary()
    {
        $attendanceTypes = AttendanceType::byTeam()->get();

        $attendances = [];
        $payrollAttendances = $this->getMeta('attendances') ?? [];
        foreach ($payrollAttendances as $attendance) {
            if (Arr::get($attendance, 'code') == 'L') {
                $attendances[] = Arr::add($attendance, 'name', trans('leave.leave'));
            }

            $attendanceType = $attendanceTypes->firstWhere('code', Arr::get($attendance, 'code'));

            if ($attendanceType) {
                $attendances[] = Arr::add($attendance, 'name', $attendanceType->name);
            }
        }

        return $attendances;
    }
}
