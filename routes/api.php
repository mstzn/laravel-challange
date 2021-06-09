<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyPackageController;
use Illuminate\Support\Facades\Route;

Route::post('/company-register', [CompanyController::class, 'store'])->name('company_register');

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('/company-package', [CompanyPackageController::class, 'store'])->name('company_package');

    Route::post('/check-company-package', [CompanyPackageController::class, 'show'])->name('check_company');

});
