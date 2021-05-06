<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory, Notifiable;

    public function vehicle(){
        return $this->hasOne(Vehicle::class);
    }

    public function booking(){
        return $this->morphOne(Booking::class, 'bookable');
    }
}
