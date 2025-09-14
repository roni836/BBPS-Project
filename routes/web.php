<?php

use App\Http\Controllers\BbpsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BBPSController::class, 'categories'])->name('categories');
Route::get('/billers/{category_name}', [BBPSController::class, 'billers'])->name('billers');
Route::get('/biller-info/{billerId}', [BBPSController::class, 'billerInfo'])->name('biller.info');
Route::post('/fetch-bill', [BBPSController::class, 'fetchBillDetails'])->name('fetch.bill');
Route::post('/pay-bill', [BBPSController::class, 'payBill'])->name('pay.bill');