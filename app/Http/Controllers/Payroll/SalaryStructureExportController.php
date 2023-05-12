<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Services\Payroll\SalaryStructureListService;
use Illuminate\Http\Request;

class SalaryStructureExportController extends Controller
{
    public function __invoke(Request $request, SalaryStructureListService $service)
    {
        $list = $service->list($request);

        return $service->export($list);
    }
}
