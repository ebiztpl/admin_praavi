<?php

use App\Http\Controllers\Attendance\AttendanceExportController;
use App\Http\Controllers\Attendance\TimesheetExportController;
use App\Http\Controllers\Attendance\TypeExportController as AttendanceTypeExportController;
use App\Http\Controllers\Attendance\WorkShiftExportController;
use Illuminate\Support\Facades\Route;

Route::get('attendance/types/export', AttendanceTypeExportController::class)->middleware('permission:attendance:config');
Route::get('attendance/export', AttendanceExportController::class)->middleware('permission:attendance:export');

Route::get('attendance/timesheets/export', TimesheetExportController::class)->middleware('permission:timesheet:export');

Route::get('attendance/work-shifts/export', WorkShiftExportController::class)->middleware('permission:work-shift:export');
