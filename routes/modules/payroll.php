<?php

use App\Http\Controllers\Payroll\PayHeadController;
use App\Http\Controllers\Payroll\PayrollController;
use App\Http\Controllers\Payroll\SalaryStructureController;
use App\Http\Controllers\Payroll\SalaryTemplateController;
use Illuminate\Support\Facades\Route;

// Payroll Routes
Route::prefix('payroll')->group(function () {
    Route::get('pay-heads/pre-requisite', [PayHeadController::class, 'preRequisite'])->name('payHeads.preRequisite')->middleware('permission:payroll:config');
    Route::apiResource('pay-heads', PayHeadController::class)->names('payHeads')->middleware('permission:payroll:config');

    Route::get('salary-templates/pre-requisite', [SalaryTemplateController::class, 'preRequisite'])->name('salaryTemplates.preRequisite');
    Route::apiResource('salary-templates', SalaryTemplateController::class)->names('salaryTemplates');

    Route::get('salary-structures/pre-requisite', [SalaryStructureController::class, 'preRequisite'])->name('salaryStructures.preRequisite');
    Route::apiResource('salary-structures', SalaryStructureController::class)->names('salaryStructures');
});

Route::get('payrolls/fetch', [PayrollController::class, 'fetch'])->name('payrolls.fetch');
Route::apiResource('payrolls', PayrollController::class)->names('payrolls');
