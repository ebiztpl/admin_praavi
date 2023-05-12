<?php

use App\Http\Controllers\Payroll\PayHeadExportController;
use App\Http\Controllers\Payroll\PayrollExportController;
use App\Http\Controllers\Payroll\SalaryStructureExportController;
use App\Http\Controllers\Payroll\SalaryTemplateExportController;
use Illuminate\Support\Facades\Route;

Route::get('payrolls/export', PayrollExportController::class)->middleware('permission:payroll:export');

Route::get('payroll/pay-heads/export', PayHeadExportController::class)->middleware('permission:payroll:config');
Route::get('payroll/salary-templates/export', SalaryTemplateExportController::class)->middleware('permission:salary-template:export');
Route::get('payroll/salary-structures/export', SalaryStructureExportController::class)->middleware('permission:salary-structure:export');
