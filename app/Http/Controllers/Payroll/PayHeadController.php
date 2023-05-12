<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\PayHeadRequest;
use App\Http\Resources\Payroll\PayHeadResource;
use App\Models\Payroll\PayHead;
use App\Services\Payroll\PayHeadListService;
use App\Services\Payroll\PayHeadService;
use Illuminate\Http\Request;

class PayHeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('test.mode.restriction')->only(['destroy']);
    }

    public function preRequisite(Request $request, PayHeadService $service)
    {
        return response()->ok($service->preRequisite($request));
    }

    public function index(Request $request, PayHeadListService $service)
    {
        return $service->paginate($request);
    }

    public function store(PayHeadRequest $request, PayHeadService $service)
    {
        $payHead = $service->create($request);

        return response()->success([
            'message' => trans('global.created', ['attribute' => trans('payroll.pay_head.pay_head')]),
            'pay_head' => PayHeadResource::make($payHead),
        ]);
    }

    public function show(PayHead $payHead, PayHeadService $service)
    {
        return PayHeadResource::make($payHead);
    }

    public function update(PayHeadRequest $request, PayHead $payHead, PayHeadService $service)
    {
        $service->update($request, $payHead);

        return response()->success([
            'message' => trans('global.updated', ['attribute' => trans('payroll.pay_head.pay_head')]),
        ]);
    }

    public function destroy(PayHead $payHead, PayHeadService $service)
    {
        $service->deletable($payHead);

        $payHead->delete();

        return response()->success([
            'message' => trans('global.deleted', ['attribute' => trans('payroll.pay_head.pay_head')]),
        ]);
    }
}
