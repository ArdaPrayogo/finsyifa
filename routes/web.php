<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\BillTypesController;
use App\Http\Controllers\MonthlyBillController;
use App\Http\Controllers\TransactionsController;

Route::get('/', function () {
    return view('dashboards/index');
});

Route::resource('/siswa', StudentsController::class);
Route::resource('/daftar_tagihan', BillTypesController::class);
Route::resource('/tagihan', BillsController::class);
Route::resource('/transaksi', TransactionsController::class);

Route::get('/massal', [BillsController::class, 'massal']);
Route::post('/massal', [BillsController::class, 'storemassal']);


Route::get('/tagihan-bulanan/create', [MonthlyBillController::class, 'create']);
Route::post('/tagihan-bulanan/store', [MonthlyBillController::class, 'store']);
