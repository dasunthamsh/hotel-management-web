@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Your Reservations</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Branch</th>
                <th>Room/Suite</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->branch->name }}</td>
                    <td>{{ $reservation->roomType->name }}</td>
                    <td>{{ $reservation->check_in_date->format('Y-m-d') }}</td>
                    <td>{{ $reservation->check_out_date->format('Y-m-d') }}</td>
                    <td>{{ $reservation->status }}</td>
                    <td>
                        @if($reservation->status === 'pending' || $reservation->status === 'confirmed')
                            <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Cancel reservation?')">Cancel</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('reservations.room') }}" class="btn btn-primary">Book Room</a>
    <a href="{{ route('reservations.suite') }}" class="btn btn-primary">Book Suite</a>
</div>
@endsection