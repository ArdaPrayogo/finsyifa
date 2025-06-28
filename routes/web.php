<?php

use App\Http\Controllers\BillsController;
use App\Http\Controllers\BillTypesController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboards/index');
});

Route::resource('/siswa', StudentsController::class);
Route::resource('/daftar_tagihan', BillTypesController::class);
Route::resource('/tagihan', BillsController::class);
Route::resource('/transaksi', TransactionsController::class);
