<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('students/index', [
            "students" => Student::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'class'        => 'required|string|max:10',
            'parent_name'  => 'required|string|max:255',
            'address'      => 'required|string',
            'phone'        => 'required|string|max:20',
        ]);

        // Tambahkan slug secara otomatis dari nama siswa
        $validated['slug'] = Str::slug($request->name);

        // Simpan data ke database
        Student::create($validated);

        // Redirect ke halaman daftar siswa dengan pesan sukses
        return redirect('/siswa')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = Student::with('bills.billType')->findOrFail($id);
        return view('students.show', compact('student'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::with('bills.billType')->findOrFail($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'class'       => 'required|string|max:10',
            'parent_name' => 'required|string|max:255',
            'address'     => 'required|string',
            'phone'       => 'required|string|max:20',
        ]);

        // Tambahkan slug dari name
        $validatedData['slug'] = Str::slug($request->name);

        // Cari data student dan update
        $student = Student::findOrFail($id);
        $student->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect('/siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect('/siswa')->with('deleted', 'Data siswa berhasil dihapus!');
    }
}
