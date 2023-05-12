<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\TypeRequest as LeaveTypeRequest;
use App\Http\Resources\Leave\TypeResource as LeaveTypeResource;
use App\Models\Leave\Type as LeaveType;
use App\Services\Leave\TypeListService as LeaveTypeListService;
use App\Services\Leave\TypeService as LeaveTypeService;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('test.mode.restriction')->only(['destroy']);
    }

    public function index(Request $request, LeaveTypeListService $service)
    {
        return $service->paginate($request);
    }

    public function store(LeaveTypeRequest $request, LeaveTypeService $service)
    {
        $leaveType = $service->create($request);

        return response()->success([
            'message' => trans('global.created', ['attribute' => trans('leave.type.type')]),
            'leave_type' => LeaveTypeResource::make($leaveType),
        ]);
    }

    public function show(LeaveType $leaveType, LeaveTypeService $service)
    {
        return LeaveTypeResource::make($leaveType);
    }

    public function update(LeaveTypeRequest $request, LeaveType $leaveType, LeaveTypeService $service)
    {
        $service->update($request, $leaveType);

        return response()->success([
            'message' => trans('global.updated', ['attribute' => trans('leave.type.type')]),
        ]);
    }

    public function destroy(LeaveType $leaveType, LeaveTypeService $service)
    {
        $service->deletable($leaveType);

        $leaveType->delete();

        return response()->success([
            'message' => trans('global.deleted', ['attribute' => trans('leave.type.type')]),
        ]);
    }
}
