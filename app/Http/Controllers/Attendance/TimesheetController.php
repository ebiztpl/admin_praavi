<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\TimesheetRequest;
use App\Http\Resources\Attendance\TimesheetResource;
use App\Models\Attendance\Timesheet;
use App\Services\Attendance\TimesheetListService;
use App\Services\Attendance\TimesheetService;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('test.mode.restriction')->only(['destroy']);
    }

    public function index(Request $request, TimesheetListService $service)
    {
        $this->authorize('viewAny', Timesheet::class);

        return $service->paginate($request);
    }

    public function store(TimesheetRequest $request, TimesheetService $service)
    {
        $this->authorize('create', Timesheet::class);

        $timesheet = $service->create($request);

        return response()->success([
            'message' => trans('global.created', ['attribute' => trans('attendance.timesheet.timesheet')]),
            'attendance_type' => TimesheetResource::make($timesheet),
        ]);
    }

    public function show(string $timesheet, TimesheetService $service)
    {
        $timesheet = Timesheet::findIfExists($timesheet);

        $this->authorize('view', $timesheet);

        return TimesheetResource::make($timesheet);
    }

    public function update(TimesheetRequest $request, string $timesheet, TimesheetService $service)
    {
        $timesheet = Timesheet::findIfExists($timesheet);

        $this->authorize('update', $timesheet);

        $service->update($request, $timesheet);

        return response()->success([
            'message' => trans('global.updated', ['attribute' => trans('attendance.timesheet.timesheet')]),
        ]);
    }

    public function destroy(string $timesheet, TimesheetService $service)
    {
        $timesheet = Timesheet::findIfExists($timesheet);

        $this->authorize('delete', $timesheet);

        $service->deletable($timesheet);

        $timesheet->delete();

        return response()->success([
            'message' => trans('global.deleted', ['attribute' => trans('attendance.timesheet.timesheet')]),
        ]);
    }
}
