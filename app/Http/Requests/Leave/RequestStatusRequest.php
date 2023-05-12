<?php

namespace App\Http\Requests\Leave;

use App\Enums\Leave\RequestStatus as LeaveRequestStatus;
use App\Helpers\CalHelper;
use App\Models\Leave\Allocation as LeaveAllocation;
use App\Models\Leave\Request as LeaveRequest;
use App\Models\Payroll\Payroll;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class RequestStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required', new Enum(LeaveRequestStatus::class)],
            'comment' => 'required|min:10|max:1000',
        ];
    }

    public function withValidator($validator)
    {
        if (! $validator->passes()) {
            return;
        }

        $validator->after(function ($validator) {
            $uuid = $this->route('leave_request');

            $leaveRequest = LeaveRequest::findIfExists($uuid);

            $leaveAllocation = LeaveAllocation::query()
                ->with('records')
                ->whereEmployeeId($leaveRequest->employee_id)
                ->where('start_date', '<=', $leaveRequest->start_date)
                ->where('end_date', '>=', $leaveRequest->end_date)
                ->getOrFail(trans('leave.allocation.allocation'));

            $leaveAllocationRecord = $leaveAllocation->records->where('leave_type_id', $leaveRequest->leave_type_id)->hasOrFail(trans('leave.type.no_allocation_found'));

            $payrollGenerated = Payroll::query()
                ->whereEmployeeId($leaveRequest->employee_id)
                ->betweenPeriod($leaveRequest->start_date, $leaveRequest->end_date)
                ->exists();

            if ($payrollGenerated) {
                throw ValidationException::withMessages(['message' => trans('leave.request.could_not_perform_if_payroll_generated')]);
            }

            $duration = CalHelper::dateDiff($leaveRequest->start_date, $leaveRequest->end_date);
            $balance = $leaveAllocationRecord->allotted - $leaveAllocationRecord->used;

            if ($balance < $duration) {
                throw ValidationException::withMessages(['message' => trans('leave.type.balance_exhausted', ['balance' => $balance, 'duration' => $duration])]);
            }

            $this->merge([
                'leave_request' => $leaveRequest,
                'leave_allocation_id' => $leaveAllocation->id,
                'duration' => $duration,
                'balance' => $balance,
            ]);
        });
    }

    /**
     * Translate fields with user friendly name.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'status' => __('leave.request.props.status'),
            'comment' => __('leave.request.props.comment'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
