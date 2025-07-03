<?php

use App\Models\Bill;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\BillTypesController;
use App\Http\Controllers\MonthlyBillController;
use App\Http\Controllers\TransactionsController;

// LOGIN
Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');
Route::get(
    '/dashboard',
    [LoginController::class, 'dashboard']
)->middleware('auth');

Route::get('/laporan', [ReportController::class, 'index'])->middleware('auth');
Route::get('/laporan/pdf', [ReportController::class, 'exportPDF'])->name('laporan.pdf');


Route::resource('/siswa', StudentsController::class)->middleware('auth');
Route::resource('/daftar_tagihan', BillTypesController::class)->middleware('auth');
Route::resource('/tagihan', BillsController::class)->middleware('auth');
Route::resource('/transaksi', TransactionsController::class)->middleware('auth');

Route::get('/massal', [BillsController::class, 'massal'])->middleware('auth');
Route::post('/massal', [BillsController::class, 'storemassal'])->middleware('auth');


Route::get('/tagihan-bulanan/create', [MonthlyBillController::class, 'create'])->middleware('auth');
Route::post('/tagihan-bulanan/store', [MonthlyBillController::class, 'store'])->middleware('auth');

Route::get('/tagihan/{id}/bayar', [BillsController::class, 'formPembayaran'])->name('tagihan.bayar')->middleware('auth');
Route::post('/tagihan/{id}/bayar', [BillsController::class, 'prosesPembayaran'])->name('tagihan.bayar.proses')->middleware('auth');


Route::get('/transaksi/{id}/nota', [TransactionsController::class, 'nota'])->name('transaksi.nota')->middleware('auth');
Route::get('/transaksi/{id}/nota-pdf', [TransactionsController::class, 'notaPdf'])->name('transaksi.nota.pdf')->middleware('auth');



Route::get('/api/get-bills-by-student/{student_id}', function ($student_id) {
    $bills = Bill::with('billType')
        ->withSum('transactions as total_paid', 'amount_paid') // Hitung total pembayaran
        ->where('student_id', $student_id)
        ->whereIn('status', ['unpaid', 'partial'])
        ->get();

    return response()->json($bills);
});
