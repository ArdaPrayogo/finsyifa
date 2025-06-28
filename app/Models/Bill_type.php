<?php

namespace App\Models;

use App\Models\Bill;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Bill_type extends Model
{
    use Sluggable;

    protected $guarded = ['id'];

    public function bills()
    {
        return $this->hasMany(Bill::class);
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
