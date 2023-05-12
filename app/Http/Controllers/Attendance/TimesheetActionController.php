<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Services\Attendance\TimesheetActionService;
use App\Services\Attendance\TimesheetSyncService;
use Illuminate\Http\Request;

class TimesheetActionController extends Controller
{
    public function __construct()
    {
        //
    }

    public function check(Request $request, TimesheetActionService $service)
    {
        return $service->check($request);
    }

    public function clock(Request $request, TimesheetActionService $service)
    {
        $data = $service->clock($request);

        return response()->success([
            'message' => trans('global.marked', ['attribute' => trans('attendance.attendance')]),
            ...$data,
        ]);
    }

    public function sync(Request $request, TimesheetSyncService $service)
    {
        $service->sync($request);

        return response()->success([
            'message' => trans('global.synched', ['attribute' => trans('attendance.timesheet.timesheet')]),
        ]);
    }
}
