@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Clerk Dashboard ({{ Auth::user()->branch->name }})</h2>
    <h3>Reservations</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Room Type</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->roomType->name }}</td>
                    <td>{{ $reservation->check_in_date->format('Y-m-d') }}</td>
                    <td>{{ $reservation->check_out_date->format('Y-m-d') }}</td>
                    <td>{{ $reservation->status }}</td>
                    <td>
                        @if($reservation->status === 'pending' || $reservation->status === 'confirmed')
                            <a href="{{ route('clerk.check-in', $reservation->id) }}" class="btn btn-sm btn-primary">Check-in</a>
                        @endif
                        @if($reservation->status === 'checked_in')
                            <a href="{{ route('clerk.check-out', $reservation->id) }}" class="btn btn-sm btn-primary">Check-out</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('clerk.room-availability') }}" class="btn btn-secondary">View Room Availability</a>
    <a href="{{ route('clerk.travel-agency') }}" class="btn btn-secondary">Travel Agency Booking</a>
</div>
@endsection