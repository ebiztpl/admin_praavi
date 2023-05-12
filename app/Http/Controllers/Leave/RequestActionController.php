<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\RequestStatusRequest as LeaveRequestStatusRequest;
use App\Services\Leave\RequestActionService as LeaveRequestActionService;

class RequestActionController extends Controller
{
    public function updateStatus(LeaveRequestStatusRequest $request, string $leaveRequest, LeaveRequestActionService $service)
    {
        $leaveRequest = $request->leave_request;

        $this->authorize('action', $leaveRequest);

        $service->updateStatus($request, $leaveRequest);

        return response()->success([
            'message' => trans('global.updated', ['attribute' => trans('leave.request.props.status')]),
        ]);
    }
}
