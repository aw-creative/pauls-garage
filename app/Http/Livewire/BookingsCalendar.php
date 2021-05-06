<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Asantibanez\LivewireCalendar\LivewireCalendar;

class BookingsCalendar extends LivewireCalendar
{

    public $booking;
    public $showEvent = false;

    public function events() : Collection
    {
        return Booking::query()
        ->whereDate('bookingStart', '>=', $this->gridStartsAt)
        ->whereDate('bookingEnd', '<=', $this->gridEndsAt)
        ->get()
        ->map(function (Booking $model) {
            return [
                'id' => $model->id,
                'title' => $model->bookable->name,
                'description' => $model->type,
                'date' => $model->bookingStart,
            ];
        });
    }

    public function onDayClick($year, $month, $day)
{
    // This event is triggered when a day is clicked
    // You will be given the $year, $month and $day for that day
}

    public function onEventClick($eventId)
    {
        $this->showEvent = true;
        $this->booking = Booking::find($eventId);
    }

    public function closeBooking(){
        $this->showEvent = false;
        unset($this->booking);
    }
}
