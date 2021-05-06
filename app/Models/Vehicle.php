<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public$timestamps = false;

    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }
}
