<?php

namespace App\Models;

use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Student extends Model
{
    use Sluggable;

    protected $guarded = ['id'];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
