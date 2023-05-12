<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\PayrollRequest;
use App\Http\Resources\Payroll\PayrollResource;
use App\Models\Payroll\Payroll;
use App\Services\Payroll\PayrollListService;
use App\Services\Payroll\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('test.mode.restriction')->only(['destroy']);
    }

    public function preRequisite(Request $request, PayrollService $service)
    {
        $this->authorize('preRequisite', Payroll::class);

        return response()->ok($service->preRequisite($request));
    }

    public function index(Request $request, PayrollListService $service)
    {
        $this->authorize('viewAny', Payroll::class);

        return $service->paginate($request);
    }

    public function fetch(PayrollRequest $request, PayrollService $service)
    {
        $this->authorize('create', Payroll::class);

        return $service->fetch($request);
    }

    public function store(PayrollRequest $request, PayrollService $service)
    {
        $this->authorize('create', Payroll::class);

        $payroll = $service->create($request);

        return response()->success([
            'message' => trans('global.created', ['attribute' => trans('payroll.payroll')]),
            'payroll' => PayrollResource::make($payroll),
        ]);
    }

    public function show(Request $request, string $payroll, PayrollService $service)
    {
        $payroll = Payroll::findIfExists($payroll);

        $this->authorize('view', $payroll);

        $request->merge(['show_attendance_summary' => true]);

        return PayrollResource::make($payroll);
    }

    public function update(PayrollRequest $request, string $payroll, PayrollService $service)
    {
        $payroll = Payroll::findIfExists($payroll);

        $this->authorize('update', $payroll);

        $service->update($request, $payroll);

        return response()->success([
            'message' => trans('global.updated', ['attribute' => trans('payroll.payroll')]),
        ]);
    }

    public function destroy(string $payroll, PayrollService $service)
    {
        $payroll = Payroll::findIfExists($payroll);

        $this->authorize('delete', $payroll);

        $service->deletable($payroll);

        $payroll->delete();

        return response()->success([
            'message' => trans('global.deleted', ['attribute' => trans('payroll.payroll')]),
        ]);
    }
}
