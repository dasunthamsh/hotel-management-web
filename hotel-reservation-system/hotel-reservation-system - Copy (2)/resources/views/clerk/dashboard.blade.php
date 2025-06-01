@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Clerk Dashboard</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('clerk.travel-agency') }}" class="btn btn-primary">Travel Agency Booking</a>
        <a href="{{ route('clerk.room-availability') }}" class="btn btn-secondary">Room Availability</a>
    </div>

    <h3>Reservations</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Branch</th>
                <th>Room Type</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Occupants</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->branch->name }}</td>
                    <td>{{ $reservation->roomType->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('Y-m-d') }}</td>
                    <td>{{ $reservation->number_of_occupants }}</td>
                    <td>{{ ucfirst($reservation->status) }}</td>
                    <td>
                        @if(in_array($reservation->status, ['confirmed', 'pending']))
                            <a href="{{ route('clerk.check-in', $reservation->id) }}" class="btn btn-sm btn-primary">Check-In</a>
                        @elseif($reservation->status === 'checked_in')
                            <a href="{{ route('clerk.check-out', $reservation->id) }}" class="btn btn-sm btn-warning">Check-Out</a>
                        @elseif($reservation->status === 'checked_out' && $reservation->updated_at >= \Carbon\Carbon::now()->subHours(24))
                            <a href="{{ route('clerk.edit-check-out', $reservation->id) }}" class="btn btn-sm btn-info">Edit Check-Out</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Travel Agency Block Bookings</h3>
    @if($travelAgencyBookings->isEmpty())
        <p>No travel agency bookings found.</p>
    @else
        @foreach($travelAgencyBookings as $agencyId => $bookings)
            <div class="mb-4">
                <h4>{{ $bookings->first()->travelAgency->name }} ({{ $bookings->count() }} Rooms)</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Room Type</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Occupants</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->reservation->roomType->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->reservation->check_in_date)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->reservation->check_out_date)->format('Y-m-d') }}</td>
                                <td>{{ $booking->reservation->number_of_occupants }}</td>
                                <td>{{ ucfirst($booking->reservation->status) }}</td>
                                <td>
                                    @if(in_array($booking->reservation->status, ['confirmed', 'pending']))
                                        <a href="{{ route('clerk.check-in', $booking->reservation->id) }}" class="btn btn-sm btn-primary">Check-In</a>
                                    @elseif($booking->reservation->status === 'checked_in')
                                        <a href="{{ route('clerk.check-out', $booking->reservation->id) }}" class="btn btn-sm btn-warning">Check-Out</a>
                                    @elseif($booking->reservation->status === 'checked_out' && $booking->reservation->updated_at >= \Carbon\Carbon::now()->subHours(24))
                                        <a href="{{ route('clerk.edit-check-out', $booking->reservation->id) }}" class="btn btn-sm btn-info">Edit Check-Out</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif
</div>
@endsection