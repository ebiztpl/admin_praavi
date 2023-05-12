<?php

use App\Http\Controllers\Leave\AllocationController as LeaveAllocationController;
use App\Http\Controllers\Leave\RequestActionController as LeaveRequestActionController;
use App\Http\Controllers\Leave\RequestController as LeaveRequestController;
use App\Http\Controllers\Leave\TypeController as LeaveTypeController;
use Illuminate\Support\Facades\Route;

// Leave Routes
Route::prefix('leave')->group(function () {
    Route::apiResource('types', LeaveTypeController::class)->parameters(['types' => 'leave_type'])->names('leaveTypes')->middleware('permission:leave:config');

    Route::get('allocations/pre-requisite', [LeaveAllocationController::class, 'preRequisite'])->name('leaveAllocations.preRequisite');
    Route::apiResource('allocations', LeaveAllocationController::class)->parameters(['allocations' => 'leave_allocation'])->names('leaveAllocations');

    Route::post('requests/{leave_request}/status', [LeaveRequestActionController::class, 'updateStatus']);
    Route::get('requests/pre-requisite', [LeaveRequestController::class, 'preRequisite'])->name('leaveRequests.preRequisite');
    Route::apiResource('requests', LeaveRequestController::class)->parameters(['requests' => 'leave_request'])->names('leaveRequests');
});
