<?php

namespace App\Http\Controllers;

use App\Models\Bill_type;
use Illuminate\Http\Request;

class BillTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $billTypes = Bill_type::all();
        return view('bill_types.index', compact('billTypes'));
    }
    public function show($id)
    {
        $billType = Bill_type::findOrFail($id);

        // Jika ingin menampilkan tagihan yang memakai jenis ini:
        $bills = \App\Models\Bill::with('student')
            ->where('bill_type_id', $billType->id)
            ->get();

        return view('bill_types.show', compact('billType', 'bills'));
    }

    public function create()
    {
        return view('bill_types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'default_amount' => 'nullable|numeric|min:0',
            'is_monthly' => 'required|boolean',
        ]);

        Bill_type::create($validated);
        return redirect('/daftar_tagihan')->with('success', 'Jenis tagihan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $billType = Bill_type::findOrFail($id);
        return view('bill_types.edit', compact('billType'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'default_amount' => 'nullable|numeric|min:0',
            'is_monthly' => 'required|boolean',
        ]);

        $billType = Bill_type::findOrFail($id);
        $billType->update($validated);

        return redirect('/daftar_tagihan')->with('success', 'Jenis tagihan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $billType = Bill_type::findOrFail($id);
        $billType->delete();
        return redirect('/daftar_tagihan')->with('deleted', 'Jenis tagihan berhasil dihapus.');
    }
}
