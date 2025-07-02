<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Bill_type;
use App\Models\bills;
use App\Models\Student;
use Illuminate\Http\Request;

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
            'billTypes' => Bill_type::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'   => 'required|exists:students,id',
            'bill_type_id' => 'required|exists:bill_types,id',
            'amount'       => 'required|numeric|min:0',
            'due_date'     => 'required|date',
            'status'       => 'required|in:unpaid,partial,paid',
        ]);

        Bill::create($validated);
        return redirect('/tagihan')->with('success', 'Tagihan berhasil ditambahkan.');
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
}
