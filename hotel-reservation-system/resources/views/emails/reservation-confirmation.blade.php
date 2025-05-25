<p>Dear {{ $reservation->user->name }},</p>
<p>Your {{ $reservation->is_suite ? 'suite' : 'room' }} reservation at {{ $reservation->branch->name }} has been confirmed.</p>
<p>Check-in: {{ $reservation->check_in_date->format('Y-m-d') }}</p>
<p>Check-out: {{ $reservation->check_out_date->format('Y-m-d') }}</p>
<p>Room Type: {{ $reservation->roomType->name }}</p>
<p>Occupants: {{ $reservation->number_of_occupants }}</p>
<p>Thank you for choosing us!</p>