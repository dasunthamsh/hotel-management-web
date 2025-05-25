@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Room Availability ({{ Auth::user()->branch->name }})</h2>
    <div id="calendar"></div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                @foreach($reservations as $reservation)
                {
                    title: '{{ $reservation->roomType->name }} ({{ $reservation->status }})',
                    start: '{{ $reservation->check_in_date->format('Y-m-d') }}',
                    end: '{{ $reservation->check_out_date->format('Y-m-d') }}'
                },
                @endforeach
            ]
        });
        calendar.render();
    });
</script>
@endsection