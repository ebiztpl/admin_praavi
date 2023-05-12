<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Services\Attendance\TypeListService as AttendanceTypeListService;
use Illuminate\Http\Request;

class TypeExportController extends Controller
{
    public function __invoke(Request $request, AttendanceTypeListService $service)
    {
        $list = $service->list($request);

        return $service->export($list);
    }
}
