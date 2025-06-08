@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Reserve a Residential Suite</h2>
    <form method="POST" action="{{ route('reservations.store') }}">
        @csrf
        <input type="hidden" name="is_suite" value="1">
        <div class="mb-3">
            <label class="form-label">Branch</label>
            <select name="branch_id" class="form-control" required>
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Room Type</label>
            <select name="room_type_id" class="form-control" required>
                <option value="">Select Suite</option>
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }} (Weekly: ${{ $type->weekly_rate }}, Monthly: ${{ $type->monthly_rate }})</option>
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
            <label class="form-label">Duration</label>
            <div class="input-group">
                <input type="number" name="duration_value" class="form-control" min="1" required placeholder="Enter number">
                <select name="duration_type" class="form-control" required>
                    <option value="weeks">Weeks</option>
                    <option value="months">Months</option>
                </select>
            </div>
            <small class="form-text text-muted">Note: A 4-week reservation will be charged at the monthly rate.</small>
            @error('duration_value') <span class="text-danger">{{ $message }}</span> @enderror
            @error('duration_type') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Number of Occupants (Max 4)</label>
            <input type="number" name="number_of_occupants" class="form-control" min="1" max="4" required>
            @error('number_of_occupants') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Credit Card Details (Optional)</label>
            <input type="text" name="credit_card_details" class="form-control">
            @error('credit_card_details') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Reserve Suite</button>
    </form>
</div>
@endsection