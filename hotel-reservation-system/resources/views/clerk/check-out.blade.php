@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Check-out Reservation #{{ $reservation->id }}</h2>
    <form method="POST" action="{{ route('clerk.check-out', $reservation->id) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Customer</label>
            <input type="text" class="form-control" value="{{ $reservation->user->name }}" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Room</label>
            <input type="text" class="form-control" value="{{ $reservation->room->room_number }}" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" class="form-control" required>
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
            </select>
            @error('payment_method') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Restaurant Charges</label>
            <input type="number" name="restaurant_charges" class="form-control" min="0" step="0.01" value="{{ $billing->restaurant_charges }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Room Service Charges</label>
            <input type="number" name="room_service_charges" class="form-control" min="0" step="0.01" value="{{ $billing->room_service_charges }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Laundry Charges</label>
            <input type="number" name="laundry_charges" class="form-control" min="0" step="0.01" value="{{ $billing->laundry_charges }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Telephone Charges</label>
            <input type="number" name="telephone_charges" class="form-control" min="0" step="0.01" value="{{ $billing->telephone_charges }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Club Facility Charges</label>
            <input type="number" name="club_facility_charges" class="form-control" min="0" step="0.01" value="{{ $billing->club_facility_charges }}">
        </div>
        <button type="submit" class="btn btn-primary">Check-out</button>
    </form>
</div>
@endsection