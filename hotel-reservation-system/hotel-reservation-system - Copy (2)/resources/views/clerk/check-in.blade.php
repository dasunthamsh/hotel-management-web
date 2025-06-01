@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Check-in Reservation #{{ $reservation->id }}</h2>
    <form method="POST" action="{{ route('clerk.check-in', $reservation->id) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Customer</label>
            <input type="text" class="form-control" value="{{ $reservation->user->name }}" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Room Type</label>
            <input type="text" class="form-control" value="{{ $reservation->roomType->name }}" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Select Room</label>
            <select name="room_id" class="form-control" required>
                @foreach($availableRooms as $room)
                    <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                @endforeach
            </select>
            @error('room_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        @if($reservation->check_in_date->isToday())
            <div class="mb-3">
                <label class="form-label">Credit Card Details</label>
                <input type="text" name="credit_card_details" class="form-control" value="{{ $reservation->credit_card_details }}">
                @error('credit_card_details') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Check-in</button>
    </form>
</div>
@endsection