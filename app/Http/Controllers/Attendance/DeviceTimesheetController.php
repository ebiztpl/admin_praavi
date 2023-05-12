<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\DeviceTimesheetRequest;
use App\Services\Attendance\DeviceTimesheetService;

class DeviceTimesheetController extends Controller
{
    public function store(DeviceTimesheetRequest $request, DeviceTimesheetService $service)
    {
        $response = $service->store($request);

        return response()->success($response);
    }
}
