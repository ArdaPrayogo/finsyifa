<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $transaksi = Transaction::with(['student', 'bill.billType'])
            ->whereMonth('payment_date', $bulan)
            ->whereYear('payment_date', $tahun)
            ->get();

        $totalPemasukan = $transaksi->sum('amount_paid');

        return view('dashboards.report', compact('transaksi', 'bulan', 'tahun', 'totalPemasukan'));
    }

    public function exportPDF(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $transaksi = Transaction::with(['student', 'bill.billType'])
            ->whereMonth('payment_date', $bulan)
            ->whereYear('payment_date', $tahun)
            ->get();

        $totalPemasukan = $transaksi->sum('amount_paid');

        $pdf = Pdf::loadView('dashboards.reportpdf', compact('transaksi', 'bulan', 'tahun', 'totalPemasukan'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream("Laporan_Keuangan_{$bulan}_{$tahun}.pdf");
    }
}
