@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Suite Reservation</h2>
    <form method="POST" action="{{ route('reservations.store') }}">
        @csrf
        <input type="hidden" name="is_suite" value="1">
        <div class="mb-3">
            <label class="form-label">Branch</label>
            <select name="branch_id" class="form-control">
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Suite Type</label>
            <select name="room_type_id" class="form-control">
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }} (Weekly: ${{ $type->weekly_rate ?? 'N/A' }}, Monthly: ${{ $type->monthly_rate ?? 'N/A' }})</option>
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
        <button type="submit" class="btn btn-primary">Reserve</button>
    </form>
</div>
@endsection