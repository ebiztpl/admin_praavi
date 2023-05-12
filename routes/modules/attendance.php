<?php

use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Attendance\TimesheetActionController;
use App\Http\Controllers\Attendance\TimesheetController;
use App\Http\Controllers\Attendance\TimesheetImportController;
use App\Http\Controllers\Attendance\TypeController as AttendanceTypeController;
use App\Http\Controllers\Attendance\WorkShiftAssignController;
use App\Http\Controllers\Attendance\WorkShiftController;
use Illuminate\Support\Facades\Route;

// Attendance Routes
Route::prefix('attendance')->group(function () {
    Route::get('types/pre-requisite', [AttendanceTypeController::class, 'preRequisite'])->name('attendanceTypes.preRequisite')->middleware('permission:attendance:config');
    Route::apiResource('types', AttendanceTypeController::class)->parameters(['types' => 'attendance_type'])->names('attendanceTypes')->middleware('permission:attendance:config');

    Route::get('pre-requisite', [AttendanceController::class, 'preRequisite'])->name('attendances.preRequisite');
    Route::get('list', [AttendanceController::class, 'list'])->name('attendances.list');
    Route::get('fetch', [AttendanceController::class, 'fetch'])->name('attendances.fetch');
    Route::post('mark', [AttendanceController::class, 'mark'])->name('attendances.mark');
    Route::get('production', [AttendanceController::class, 'fetchProduction'])->name('attendances.fetchProduction');
    Route::post('production', [AttendanceController::class, 'markProduction'])->name('attendances.markProduction');

    Route::get('timesheet/check', [TimesheetActionController::class, 'check'])->name('attendances.checkTimesheet');
    Route::post('timesheet/clock', [TimesheetActionController::class, 'clock'])
        ->name('attendances.clockTimesheet')
        ->middleware('throttle:timesheet');
    Route::post('timesheet/sync', [TimesheetActionController::class, 'sync'])
        ->name('attendances.syncTimesheet')
        ->middleware('permission:timesheet:sync');

    Route::post('timesheets/import', TimesheetImportController::class)->middleware('permission:timesheet:import');
    Route::apiResource('timesheets', TimesheetController::class)->names('timesheets');

    Route::get('work-shift/assign/pre-requisite', [WorkShiftAssignController::class, 'preRequisite'])->name('workShifts.assign.preRequisite');
    Route::get('work-shift/assign/fetch', [WorkShiftAssignController::class, 'fetch'])->name('workShifts.assign.fetch');
    Route::post('work-shift/assign', [WorkShiftAssignController::class, 'assign'])->name('workShifts.assign');

    Route::get('work-shifts/pre-requisite', [WorkShiftController::class, 'preRequisite'])->name('workShifts.preRequisite');
    Route::apiResource('work-shifts', WorkShiftController::class)->names('workShifts');
});
