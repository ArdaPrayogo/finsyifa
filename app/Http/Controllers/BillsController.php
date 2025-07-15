<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\bills;
use App\Models\Student;
use App\Models\Bill_type;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $bills = Bill::with(['student', 'billType'])->get();
        return view('bills.index', compact('bills'));
    }

    public function show($id)
    {
        $bill = \App\Models\Bill::with(['student', 'billType'])->findOrFail($id);
        return view('bills.show', compact('bill'));
    }


    public function create()
    {
        return view('bills.create', [
            'students' => Student::all(),
            'billTypes' => Bill_type::where('is_monthly', false)->get(),
        ]);
    }
    public function massal()
    {
        return view('bills.createmassal', [
            'students' => Student::all(),
            'billTypes' => Bill_type::where('is_monthly', false)->get(),
        ]);
    }

    public function storeMassal(Request $request)
    {
        $request->validate([
            'student_ids'   => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'bill_type_ids' => 'required|array',
            'bill_type_ids.*' => 'exists:bill_types,id',
            'due_date'      => 'required|date',
        ]);

        $studentIds = $request->student_ids;
        $billTypeIds = $request->bill_type_ids;
        $dueDate = $request->due_date;

        foreach ($studentIds as $studentId) {
            foreach ($billTypeIds as $billTypeId) {
                $billType = Bill_type::findOrFail($billTypeId);

                Bill::create([
                    'student_id'   => $studentId,
                    'bill_type_id' => $billTypeId,
                    'amount'       => $billType->default_amount,
                    'due_date'     => $dueDate,
                    'status'       => 'unpaid',
                ]);
            }
        }

        return redirect('/tagihan')->with('success', 'Tagihan massal berhasil ditambahkan!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'bill_type_id' => 'required|exists:bill_types,id',
            'due_date'     => 'required|date',
            'status'       => 'required|in:unpaid,partial,paid',
            'amount'       => 'nullable|numeric|min:0',
        ]);

        $billType = Bill_type::findOrFail($request->bill_type_id);

        // Gunakan amount dari input jika ada, jika tidak pakai default_amount
        $amount = $request->filled('amount') ? $request->amount : $billType->default_amount;

        Bill::create([
            'student_id'   => $request->student_id,
            'bill_type_id' => $request->bill_type_id,
            'amount'       => $amount,
            'due_date'     => $request->due_date,
            'status'       => $request->status,
        ]);

        return redirect('/tagihan')->with('success', 'Tagihan berhasil ditambahkan!');
    }



    public function edit($id)
    {
        $bill = Bill::findOrFail($id);
        return view('bills.edit', [
            'bill' => $bill,
            'students' => Student::all(),
            'billTypes' => Bill_type::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id'   => 'required|exists:students,id',
            'bill_type_id' => 'required|exists:bill_types,id',
            'amount'       => 'required|numeric|min:0',
            'due_date'     => 'required|date',
            'status'       => 'required|in:unpaid,partial,paid',
        ]);

        $bill = Bill::findOrFail($id);
        $bill->update($validated);

        return redirect('/tagihan')->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bill = Bill::findOrFail($id);
        $bill->delete();

        return redirect('/tagihan')->with('deleted', 'Tagihan berhasil dihapus.');
    }

    public function formPembayaran($id)
    {
        $bill = Bill::with('student', 'transactions')->findOrFail($id);
        $sisa = $bill->amount - $bill->transactions->sum('amount_paid');
        return view('bills.bayar', compact('bill', 'sisa'));
    }


    public function prosesPembayaran(Request $request, $id)
    {
        $bill = Bill::with('transactions')->findOrFail($id);
        $sisa = $bill->amount - $bill->transactions->sum('amount_paid');

        $validated = $request->validate([
            'payment_date' => 'required|date',
            'amount_paid'  => "required|numeric|min:1|max:$sisa",
            'note'         => 'nullable|string',
            'signature'    => 'nullable|string', // base64 image
        ]);

        $validated['bill_id'] = $bill->id;
        $validated['student_id'] = $bill->student_id;

        // Simpan tanda tangan jika ada
        if (!empty($validated['signature'])) {
            $image = $validated['signature'];

            // Hapus prefix base64
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageData = base64_decode($image);

            // Nama file
            $filename = 'signature_' . Str::random(10) . '.png';
            $path = 'signatures/' . $filename;

            // Simpan ke storage/public/signatures
            Storage::disk('public')->put($path, $imageData);

            // Tambahkan path ke data
            $validated['signature_path'] = $path;
        }

        // Simpan transaksi
        Transaction::create($validated);

        // Hitung ulang total dibayar termasuk transaksi baru
        $totalPaid = $bill->transactions->sum('amount_paid') + $validated['amount_paid'];

        // Update status tagihan
        $bill->status = $totalPaid >= $bill->amount ? 'paid' : 'partial';
        $bill->save();

        return redirect('/tagihan/' . $bill->id)->with('success', 'Pembayaran berhasil dilakukan.');
    }
}
