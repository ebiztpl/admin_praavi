<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Services\Payroll\SalaryTemplateListService;
use Illuminate\Http\Request;

class SalaryTemplateExportController extends Controller
{
    public function __invoke(Request $request, SalaryTemplateListService $service)
    {
        $list = $service->list($request);

        return $service->export($list);
    }
}
