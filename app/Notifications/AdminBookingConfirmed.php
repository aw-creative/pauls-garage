<?php

namespace App\Notifications;

use app\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminBookingConfirmed extends Notification implements ShouldQueue
{
    use Queueable;


    public Booking $booking;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('A booking has Been Confirmed for ' . $this->booking->bookable->name)
                    ->line('A ' . $this->booking->bookable->vehicle->make .' is booked in at ' . \Carbon\Carbon::parse($this->booking->bookingDay . '' .  $this->booking->bookingTime)->toDayDateTimeString());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
