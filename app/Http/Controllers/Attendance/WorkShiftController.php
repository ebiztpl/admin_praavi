<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\WorkShiftRequest;
use App\Http\Resources\Attendance\WorkShiftResource;
use App\Models\Attendance\WorkShift;
use App\Services\Attendance\WorkShiftListService;
use App\Services\Attendance\WorkShiftService;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('test.mode.restriction')->only(['destroy']);
    }

    public function preRequisite(Request $request, WorkShiftService $service)
    {
        $this->authorize('preRequisite', WorkShift::class);

        return response()->ok($service->preRequisite($request));
    }

    public function index(Request $request, WorkShiftListService $service)
    {
        $this->authorize('viewAny', WorkShift::class);

        return $service->paginate($request);
    }

    public function store(WorkShiftRequest $request, WorkShiftService $service)
    {
        $this->authorize('create', WorkShift::class);

        $workShift = $service->create($request);

        return response()->success([
            'message' => trans('global.created', ['attribute' => trans('attendance.work_shift.work_shift')]),
            'attendance_type' => WorkShiftResource::make($workShift),
        ]);
    }

    public function show(WorkShift $workShift, WorkShiftService $service)
    {
        $this->authorize('view', $workShift);

        return WorkShiftResource::make($workShift);
    }

    public function update(WorkShiftRequest $request, WorkShift $workShift, WorkShiftService $service)
    {
        $this->authorize('update', $workShift);

        $service->update($request, $workShift);

        return response()->success([
            'message' => trans('global.updated', ['attribute' => trans('attendance.work_shift.work_shift')]),
        ]);
    }

    public function destroy(WorkShift $workShift, WorkShiftService $service)
    {
        $this->authorize('delete', $workShift);

        $service->deletable($workShift);

        $workShift->delete();

        return response()->success([
            'message' => trans('global.deleted', ['attribute' => trans('attendance.work_shift.work_shift')]),
        ]);
    }
}
