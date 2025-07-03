<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\transactions;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transactions/index', [
            "transactions" => Transaction::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();

        // Ambil hanya tagihan yang belum lunas atau sebagian
        $bills = Bill::with('student', 'billType')
            ->whereIn('status', ['unpaid', 'partial'])
            ->get();

        return view('transactions.create', compact('students', 'bills'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'   => 'required|exists:students,id',
            'bill_id'      => 'required|exists:bills,id',
            'amount_paid'  => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'note'         => 'nullable|string',
        ]);

        // Simpan transaksi
        $transaction = Transaction::create($validated);

        // Ambil tagihan terkait
        $bill = Bill::find($validated['bill_id']);

        // Hitung total pembayaran sejauh ini
        $totalPaid = Transaction::where('bill_id', $bill->id)->sum('amount_paid');

        // Update status tagihan
        if ($totalPaid >= $bill->amount) {
            $bill->status = 'paid';
        } elseif ($totalPaid > 0) {
            $bill->status = 'partial';
        } else {
            $bill->status = 'unpaid';
        }

        $bill->save();

        return redirect('/transaksi')->with('success', 'Transaksi berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaction = Transaction::with('student')->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $students = Student::all();
        return view('transactions.edit', compact('transaction', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'bill_id' => 'required|exists:bills,id',
            'amount_paid' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update($validated);

        return redirect('/transaksi')->with('success', 'Transaksi berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect('/transaksi')->with('success', 'Transaksi berhasil dihapus.');
    }


    public function nota($id)
    {
        $transaction = Transaction::with('student', 'bill.billType')->findOrFail($id);
        return view('transactions.nota', compact('transaction'));
    }

    public function notaPdf($id)
    {
        $transaction = Transaction::with('student', 'bill.billType')->findOrFail($id);
        $pdf = Pdf::loadView('transactions.nota', compact('transaction'));
        return $pdf->download('nota-transaksi-' . $transaction->id . '.pdf');
    }
}
