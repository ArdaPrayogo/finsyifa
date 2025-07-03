<?php

use App\Models\Bill;
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

Route::get('/tagihan/{id}/bayar', [BillsController::class, 'formPembayaran'])->name('tagihan.bayar');
Route::post('/tagihan/{id}/bayar', [BillsController::class, 'prosesPembayaran'])->name('tagihan.bayar.proses');


Route::get('/api/get-bills-by-student/{student_id}', function ($student_id) {
    $bills = Bill::with('billType')
        ->withSum('transactions as total_paid', 'amount_paid') // Hitung total pembayaran
        ->where('student_id', $student_id)
        ->whereIn('status', ['unpaid', 'partial'])
        ->get();

    return response()->json($bills);
});
