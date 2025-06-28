<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Bill_type;
use App\Models\bill_types;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill_type $bill_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill_type $bill_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill_type $bill_type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill_type $bill_type)
    {
        //
    }
}
