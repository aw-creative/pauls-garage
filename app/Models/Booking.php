<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    public $timestamps = [
        'bookingStart',
        'bookingEnd'
    ];

    public function bookable(){
        return $this->morphTo();
    }
}
