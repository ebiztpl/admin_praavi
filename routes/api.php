<?php

use App\Http\Controllers\Attendance\DeviceTimesheetController;
use App\Http\Controllers\Config\ConfigController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MobileController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Global Routes
Route::get('config/pre-requisite', [ConfigController::class, 'preRequisite'])->name('config.preRequisite');
Route::get('config', [ConfigController::class, 'index'])->name('config');

Route::post('timesheet', [DeviceTimesheetController::class, 'store'])
    ->name('device.timesheet.store')
    ->middleware('throttle:biometric');

// Fallback route
Route::fallback(function () {
    return response()->json(['message' => trans('general.errors.api_not_found')], 404);
});


Route::post('login_app', [MobileController::class, 'login_app'])->name('login_app');

Route::post('home_data', [MobileController::class, 'home_data'])->name('home_data');

Route::post('punch_in', [MobileController::class, 'punch_in'])->name('punch_in');

Route::post('punch_out', [MobileController::class, 'punch_out'])->name('punch_out');