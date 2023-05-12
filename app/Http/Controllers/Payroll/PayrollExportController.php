<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Services\Payroll\PayrollListService;
use Illuminate\Http\Request;

class PayrollExportController extends Controller
{
    public function __invoke(Request $request, PayrollListService $service)
    {
        $list = $service->list($request);

        return $service->export($list);
    }
}
