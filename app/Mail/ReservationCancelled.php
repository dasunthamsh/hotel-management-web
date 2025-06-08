<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this->subject('Reservation Cancelled')
                    ->view('emails.reservation_cancelled')
                    ->with([
                        'reservation' => $this->reservation,
                        'hotelName' => config('app.name', 'Hotel Reservation System')
                    ]);
    }
}