<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Services\Attendance\AttendanceListService;
use Illuminate\Http\Request;

class AttendanceExportController extends Controller
{
    public function __invoke(Request $request, AttendanceListService $service)
    {
        $list = $service->list($request);

        return $service->export($list);
    }
}
