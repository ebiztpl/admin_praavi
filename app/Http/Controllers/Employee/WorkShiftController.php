<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\WorkShiftRequest;
use App\Http\Resources\Employee\WorkShiftResource;
use App\Models\Employee\Employee;
use App\Services\Employee\WorkShiftListService;
use App\Services\Employee\WorkShiftService;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('test.mode.restriction')->only(['destroy']);
    }

    public function index(Request $request, string $employee, WorkShiftListService $service)
    {
        $employee = Employee::findWithSummaryOrFail($employee);

        return $service->paginate($request, $employee);
    }

    public function store(WorkShiftRequest $request, string $employee, WorkShiftService $service)
    {
        $employee = Employee::findWithSummaryOrFail($employee);

        $workShift = $service->create($request, $employee);

        return response()->success([
            'message' => trans('global.created', ['attribute' => trans('attendance.work_shift.work_shift')]),
            'work_shift' => WorkShiftResource::make($workShift),
        ]);
    }

    public function show(string $employee, string $workShift, WorkShiftService $service)
    {
        $employee = Employee::findWithSummaryOrFail($employee);

        $workShift = $service->findByUuidOrFail($employee, $workShift);

        $workShift->load('workShift');

        return WorkShiftResource::make($workShift);
    }

    public function update(WorkShiftRequest $request, string $employee, string $workShift, WorkShiftService $service)
    {
        $employee = Employee::findWithSummaryOrFail($employee);

        $workShift = $service->findByUuidOrFail($employee, $workShift);

        $service->update($request, $employee, $workShift);

        return response()->success([
            'message' => trans('global.updated', ['attribute' => trans('attendance.work_shift.work_shift')]),
        ]);
    }

    public function destroy(string $employee, string $workShift, WorkShiftService $service)
    {
        $employee = Employee::findWithSummaryOrFail($employee);

        $workShift = $service->findByUuidOrFail($employee, $workShift);

        $service->deletable($employee, $workShift);

        $workShift->delete();

        return response()->success([
            'message' => trans('global.deleted', ['attribute' => trans('attendance.work_shift.work_shift')]),
        ]);
    }
}
