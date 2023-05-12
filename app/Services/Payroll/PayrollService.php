<?php

namespace App\Services\Payroll;

use App\Actions\Payroll\CalculatePayroll;
use App\Enums\Finance\PaymentStatus;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\Record;
use App\Support\Evaluator;
use App\Support\FormatCodeNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class PayrollService
{
    use Evaluator, FormatCodeNumber;

    private function codeNumber(Request $request)
    {
        $numberPrefix = config('config.payroll.code_number_prefix');
        $numberSuffix = config('config.payroll.code_number_suffix');
        $digit = config('config.payroll.code_number_digit', 0);

        $numberFormat = $numberPrefix.'%NUMBER%'.$numberSuffix;
        $codeNumber = (int) Payroll::whereHas('employee', function ($q) {
            $q->byTeam();
        })->whereNumberFormat($numberFormat)->max('number') + 1;

        return $this->getCodeNumber(number: $codeNumber, digit: $digit, format: $numberFormat);
    }

    private function validateCodeNumber(Request $request, string $uuid = null): array
    {
        if (! $request->code_number) {
            return $this->codeNumber($request);
        }

        $duplicateCodeNumber = Payroll::whereHas('employee', function ($q) {
            $q->byTeam();
        })->whereCodeNumber($request->code_number)->when($uuid, function ($q, $uuid) {
            $q->where('uuid', '!=', $uuid);
        })->count();

        if ($duplicateCodeNumber) {
            throw ValidationException::withMessages(['message' => trans('global.duplicate', ['attribute' => trans('payroll.config.props.code_number')])]);
        }
    }

    public function preRequisite(Request $request): array
    {
        return [];
    }

    public function fetch(Request $request): array
    {
        [$attendanceSummary, $records] = (new CalculatePayroll)->execute(
            employeeId: $request->employee->id,
            startDate: $request->start_date,
            endDate: $request->end_date,
            salaryStructure: $request->salary_structure,
            attendanceTypes: $request->attendance_types,
            productionAttendanceTypes: $request->production_attendance_types,
        );

        $netEarning = collect($records)->filter(function ($record) {
            return $record['pay_head']['type'] == 'earning';
        })->sum('amount');

        $netDeduction = collect($records)->filter(function ($record) {
            return $record['pay_head']['type'] == 'deduction';
        })->sum('amount');

        $netSalary = $netEarning - $netDeduction;

        $records = collect($records);
        $records = array_values($records->sortBy('pay_head.position')->all());

        return compact('attendanceSummary', 'records', 'netEarning', 'netDeduction', 'netSalary');
    }

    public function create(Request $request): Payroll
    {
        \DB::beginTransaction();

        $payroll = Payroll::forceCreate($this->formatParams($request));

        $this->updateRecords($request, $payroll);

        \DB::commit();

        return $payroll;
    }

    private function formatParams(Request $request, ?Payroll $payroll = null): array
    {
        $codeNumberDetail = $this->validateCodeNumber($request, $payroll?->uuid);

        $formatted = [
            'remarks' => $request->remarks,
        ];

        if (! $payroll) {
            $formatted['employee_id'] = $request->employee->id;
            $formatted['salary_structure_id'] = $request->salary_structure->id;
            $formatted['start_date'] = $request->start_date;
            $formatted['end_date'] = $request->end_date;
            $formatted['number_format'] = Arr::get($codeNumberDetail, 'number_format');
            $formatted['number'] = Arr::get($codeNumberDetail, 'number');
            $formatted['code_number'] = Arr::get($codeNumberDetail, 'code_number', $request->code_number);
        }

        return $formatted;
    }

    private function updateRecords(Request $request, Payroll $payroll): void
    {
        $data = $this->fetch($request);

        $calculatedRecords = Arr::get($data, 'records', []);

        $calculatedAttendances = Arr::get($data, 'attendanceSummary', []);
        $attendances = Arr::map($calculatedAttendances, function ($item) {
            return ['code' => Arr::get($item, 'code'), 'count' => Arr::get($item, 'count'), 'unit' => Arr::get($item, 'unit')];
        });

        $calculated = [
            'earning' => Arr::get($data, 'netEarning'),
            'deduction' => Arr::get($data, 'netDeduction'),
            'salary' => Arr::get($data, 'netSalary'),
        ];

        $actual = [
            'earning' => $request->earning,
            'deduction' => $request->deduction,
            'salary' => $request->total,
        ];

        $meta = $payroll->meta;
        $meta['attendances'] = $attendances;
        $meta['calculated'] = $calculated;
        $meta['actual'] = $actual;
        $payroll->meta = $meta;

        $payroll->total = $request->total;
        $payroll->status = PaymentStatus::UNPAID->value;
        $payroll->save();

        foreach ($request->records as $record) {
            $calculatedRecord = Arr::first($calculatedRecords, function ($item) use ($record) {
                return Arr::get($item, 'pay_head.uuid') == Arr::get($record, 'pay_head.uuid');
            });

            $payrollRecord = Record::firstOrCreate([
                'payroll_id' => $payroll->id,
                'pay_head_id' => Arr::get($record, 'pay_head.id'),
            ]);

            $payrollRecord->calculated = Arr::get($calculatedRecord, 'amount');
            $payrollRecord->amount = Arr::get($record, 'amount');

            $payrollRecord->save();
        }
    }

    private function ensureIsLastPayroll(Payroll $payroll): void
    {
        $isLastPayroll = Payroll::whereEmployeeId($payroll->employee_id)->where('start_date', '>', $payroll->start_date)->doesntExist();

        if (! $isLastPayroll) {
            throw ValidationException::withMessages(['message' => trans('global.could_not_modify_past_record', ['attribute' => trans('payroll.payroll')])]);
        }
    }

    public function update(Request $request, Payroll $payroll): void
    {
        $this->ensureIsLastPayroll($payroll);

        \DB::beginTransaction();

        $payroll->forceFill($this->formatParams($request, $payroll))->save();

        $this->updateRecords($request, $payroll);

        \DB::commit();
    }

    public function deletable(Payroll $payroll): void
    {
        $this->ensureIsLastPayroll($payroll);
    }
}
