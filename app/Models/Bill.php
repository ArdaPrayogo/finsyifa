<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Bill_type;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function billType()
    {
        return $this->belongsTo(Bill_type::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
