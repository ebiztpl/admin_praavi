<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\AttendanceRequest;
use App\Http\Requests\Attendance\ProductionRequest;
use App\Models\Attendance\Attendance;
use App\Services\Attendance\AttendanceListService;
use App\Services\Attendance\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function preRequisite(Request $request, AttendanceService $service)
    {
        $this->authorize('preRequisite', Attendance::class);

        return $service->preRequisite($request);
    }

    public function list(Request $request, AttendanceListService $service)
    {
        $this->authorize('list', Attendance::class);

        return $service->paginate($request);
    }

    public function fetch(Request $request, AttendanceService $service)
    {
        $this->authorize('mark', Attendance::class);

        return $service->fetch($request);
    }

    public function mark(AttendanceRequest $request, AttendanceService $service)
    {
        $this->authorize('mark', Attendance::class);

        $service->mark($request);

        return response()->success([
            'message' => trans('global.marked', ['attribute' => trans('attendance.attendance')]),
        ]);
    }

    public function fetchProduction(ProductionRequest $request, AttendanceService $service)
    {
        $this->authorize('mark', Attendance::class);

        return $service->fetchProduction($request);
    }

    public function markProduction(ProductionRequest $request, AttendanceService $service)
    {
        $this->authorize('mark', Attendance::class);

        $service->markProduction($request);

        return response()->success([
            'message' => trans('global.marked', ['attribute' => trans('attendance.attendance')]),
        ]);
    }
}
