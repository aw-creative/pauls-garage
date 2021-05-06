<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Asantibanez\LivewireCalendar\LivewireCalendar;

class BookingsCalendar extends LivewireCalendar
{

    public $booking;
    public $showEvent = false;
    public $showDayBlock = false;
    public $dayToBook;

    public function events() : Collection
    {
        return Booking::query()
        ->whereDate('bookingDay', '>=', $this->gridStartsAt)
        ->whereDate('bookingDay', '<=', $this->gridEndsAt)
        ->get()
        ->map(function (Booking $model) {
            return [
                'id' => $model->id,
                'title' => $model->bookable->name,
                'description' => $model->type,
                'date' => $model->bookingDay,
            ];
        });
    }

    public function onDayClick($year, $month, $day)
{
        $this->showDayBlock = true;
        $this->dayToBook = Carbon::parse($year .'-'. $month .'-'. $day);
}
    public function bookDay(){
        $booking = new Booking;
        $booking->fill(['type'=> 'internal','bookingDay' => $this->dayToBook]);
        $user = Auth::User();
        $user->booking()->save($booking);
        $this->showDayBlock = false;
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
