<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\TypeRequest as AttendanceTypeRequest;
use App\Http\Resources\Attendance\TypeResource as AttendanceTypeResource;
use App\Models\Attendance\Type as AttendanceType;
use App\Services\Attendance\TypeListService as AttendanceTypeListService;
use App\Services\Attendance\TypeService as AttendanceTypeService;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('test.mode.restriction')->only(['destroy']);
    }

    public function preRequisite(Request $request, AttendanceTypeService $service)
    {
        return response()->ok($service->preRequisite($request));
    }

    public function index(Request $request, AttendanceTypeListService $service)
    {
        return $service->paginate($request);
    }

    public function store(AttendanceTypeRequest $request, AttendanceTypeService $service)
    {
        $attendanceType = $service->create($request);

        return response()->success([
            'message' => trans('global.created', ['attribute' => trans('attendance.type.type')]),
            'attendance_type' => AttendanceTypeResource::make($attendanceType),
        ]);
    }

    public function show(AttendanceType $attendanceType, AttendanceTypeService $service)
    {
        return AttendanceTypeResource::make($attendanceType);
    }

    public function update(AttendanceTypeRequest $request, AttendanceType $attendanceType, AttendanceTypeService $service)
    {
        $service->update($request, $attendanceType);

        return response()->success([
            'message' => trans('global.updated', ['attribute' => trans('attendance.type.type')]),
        ]);
    }

    public function destroy(AttendanceType $attendanceType, AttendanceTypeService $service)
    {
        $service->deletable($attendanceType);

        $attendanceType->delete();

        return response()->success([
            'message' => trans('global.deleted', ['attribute' => trans('attendance.type.type')]),
        ]);
    }
}
