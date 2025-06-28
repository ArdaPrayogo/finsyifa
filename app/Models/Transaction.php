<?php

namespace App\Models;

use App\Models\Bill;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
