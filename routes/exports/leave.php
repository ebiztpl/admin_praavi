<?php

use App\Http\Controllers\Leave\AllocationExportController as LeaveAllocationExportController;
use App\Http\Controllers\Leave\RequestController as LeaveRequestController;
use App\Http\Controllers\Leave\RequestExportController as LeaveRequestExportController;
use App\Http\Controllers\Leave\TypeExportController as LeaveTypeExportController;
use Illuminate\Support\Facades\Route;

Route::get('leave/types/export', LeaveTypeExportController::class)->middleware('permission:leave:config');
Route::get('leave/allocations/export', LeaveAllocationExportController::class)->middleware('permission:leave-allocation:export');

Route::get('leave/requests/{leave_request}/media/{uuid}', [LeaveRequestController::class, 'downloadMedia']);

Route::get('leave/requests/export', LeaveRequestExportController::class)->middleware('permission:leave-request:export');
