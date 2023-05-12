<?php

namespace App\Http\Controllers;

use App\Services\Dashboard\AttendanceChartService;
use App\Services\Dashboard\RecordService;
use App\Services\Dashboard\StatService;
use App\Services\Dashboard\UserAgendaService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard stats
     */
    public function stat(Request $request, StatService $service)
    {
        return $service->getData($request);
    }

    public function agenda(Request $request, UserAgendaService $service)
    {
        return $service->getData($request);
    }

    public function chart(Request $request, AttendanceChartService $service)
    {
        return $service->getData($request);
    }

    public function record(Request $request, RecordService $service)
    {
        return $service->getData($request);
    }
}
