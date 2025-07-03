<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Bill;
use App\Models\Bill_type;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class MonthlyBillController extends Controller
{
    public function create()
    {
        return view('bills.createbulanan', [
            'students' => Student::all(),
            'billTypes' => Bill_type::where('is_monthly', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'bill_type_ids' => 'required|array',
            'start_month' => 'required|integer|min:1|max:12',
            'start_year' => 'required|integer|min:2020',
            'jumlah_bulan' => 'required|integer|min:1|max:12',
            'tanggal_jatuh_tempo' => 'required|integer|min:1|max:28',
        ]);

        $students = $request->student_ids;
        $billTypes = $request->bill_type_ids;
        $startMonth = $request->start_month;
        $startYear = $request->start_year;
        $jumlahBulan = $request->jumlah_bulan;
        $day = $request->tanggal_jatuh_tempo;

        foreach ($students as $student_id) {
            foreach ($billTypes as $bill_type_id) {
                $billType = Bill_type::find($bill_type_id);
                $amount = $billType->default_amount ?? 0;

                for ($i = 0; $i < $jumlahBulan; $i++) {
                    $month = ($startMonth + $i - 1) % 12 + 1;
                    $year = $startYear + floor(($startMonth + $i - 1) / 12);

                    $due_date = \Carbon\Carbon::createFromDate($year, $month, $day);

                    Bill::create([
                        'student_id' => $student_id,
                        'bill_type_id' => $bill_type_id,
                        'amount' => $amount,
                        'due_date' => $due_date,
                        'status' => 'unpaid',
                        'month' => $month,
                        'year' => $year,
                    ]);
                }
            }
        }

        return redirect('/tagihan')->with('success', 'Tagihan bulanan berhasil ditambahkan.');
    }
}
