@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Room Availability ({{ Auth::user()->branch->name }})</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Available Rooms -->
    <h3>Available Rooms</h3>
    @if(empty($availableRooms))
        <p>No rooms are currently available.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($availableRooms as $room)
                    <tr>
                        <td>{{ $room['room']->room_number }}</td>
                        <td>{{ $room['room_type'] }}</td>
                        <td>{{ ucfirst($room['room']->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Checked-In Rooms -->
    <h3>Checked-In Rooms</h3>
    @if(empty($checkedInRooms))
        <p>No rooms are currently checked-in.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Guest Name</th>
                    <th>Check-In Date</th>
                    <th>Check-Out Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkedInRooms as $room)
                    <tr>
                        <td>{{ $room['room']->room_number }}</td>
                        <td>{{ $room['room']->roomType->name }}</td>
                        <td>{{ $room['customer'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($room['check_in_date'])->format('Y-m-d') }}</td>
                        <td>{{ \Carbon\Carbon::parse($room['check_out_date'])->format('Y-m-d') }}</td>
                        <td>{{ ucfirst($room['reservation']->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('clerk.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection