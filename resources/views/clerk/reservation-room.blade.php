@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Room Reservation</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('clerk.reservation.store') }}">
        @csrf
        <input type="hidden" name="is_suite" value="0">
        <input type="hidden" name="branch_id" value="{{ $branch->id }}">
        <div class="mb-3">
            <label class="form-label">Branch</label>
            <input type="text" class="form-control" value="{{ $branch->name }}" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Customer</label>
            <select name="user_id" class="form-control" required>
                <option value="">Select Customer</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Room Type</label>
            <select name="room_type_id" class="form-control" required>
                <option value="">Select Room Type</option>
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }} (${{ $type->price_per_night }}/night)</option>
                @endforeach
            </select>
            @error('room_type_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Check-in Date</label>
            <input type="date" name="check_in_date" class="form-control" required>
            @error('check_in_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Check-out Date</label>
            <input type="date" name="check_out_date" class="form-control" required>
            @error('check_out_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Number of Occupants</label>
            <input type="number" name="number_of_occupants" class="form-control" min="1" required>
            @error('number_of_occupants') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Credit Card Details (Optional)</label>
            <input type="text" name="credit_card_details" class="form-control">
            @error('credit_card_details') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Reserve Room</button>
        <a href="{{ route('clerk.dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection