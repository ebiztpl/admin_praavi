<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\WorkShiftAssignRequest;
use App\Models\Attendance\WorkShift;
use App\Services\Attendance\WorkShiftAssignService;
use Illuminate\Http\Request;

class WorkShiftAssignController extends Controller
{
    public function preRequisite(Request $request, WorkShiftAssignService $service)
    {
        $this->authorize('assign', WorkShift::class);

        return $service->preRequisite($request);
    }

    public function fetch(Request $request, WorkShiftAssignService $service)
    {
        $this->authorize('assign', WorkShift::class);

        return $service->fetch($request);
    }

    public function assign(WorkShiftAssignRequest $request, WorkShiftAssignService $service)
    {
        $this->authorize('assign', WorkShift::class);

        $service->assign($request);

        return response()->success([
            'message' => trans('global.assigned', ['attribute' => trans('attendance.work_shift.work_shift')]),
        ]);
    }
}
