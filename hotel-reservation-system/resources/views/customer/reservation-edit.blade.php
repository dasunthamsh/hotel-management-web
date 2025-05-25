@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Reservation #{{ $reservation->id }}</h2>
    <form method="POST" action="{{ route('reservations.update', $reservation->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="is_suite" value="{{ $reservation->is_suite }}">
        <div class="mb-3">
            <label class="form-label">Branch</label>
            <select name="branch_id" class="form-control">
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $reservation->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
            @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">{{ $reservation->is_suite ? 'Suite' : 'Room' }} Type</label>
            <select name="room_type_id" class="form-control">
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}" {{ $reservation->room_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
            @error('room_type_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Check-in Date</label>
            <input type="date" name="check_in_date" class="form-control" value="{{ $reservation->check_in_date->format('Y-m-d') }}" required>
            @error('check_in_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Check-out Date</label>
            <input type="date" name="check_out_date" class="form-control" value="{{ $reservation->check_out_date->format('Y-m-d') }}" required>
            @error('check_out_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Number of Occupants</label>
            <input type="number" name="number_of_occupants" class="form-control" min="1" value="{{ $reservation->number_of_occupants }}" required>
            @error('number_of_occupants') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Credit Card Details (Optional)</label>
            <input type="text" name="credit_card_details" class="form-control" value="{{ $reservation->credit_card_details }}">
            @error('credit_card_details') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection