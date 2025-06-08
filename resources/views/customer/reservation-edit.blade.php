@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Reservation</h2>
    <form method="POST" action="{{ route('reservations.update', $reservation->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="is_suite" value="{{ $reservation->roomType->is_suite ? 1 : 0 }}">
        <div class="mb-3">
            <label class="form-label">Branch</label>
            <select name="branch_id" class="form-control" required>
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $reservation->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
            @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Room Type</label>
            <select name="room_type_id" class="form-control" required>
                <option value="">Select Room Type</option>
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}" {{ $reservation->room_type_id == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                        @if($type->is_suite)
                            (Weekly: ${{ $type->weekly_rate }}, Monthly: ${{ $type->monthly_rate }})
                        @else
                            (${{ $type->price_per_night }}/night)
                        @endif
                    </option>
                @endforeach
            </select>
            @error('room_type_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Check-in Date</label>
            <input type="date" name="check_in_date" class="form-control" value="{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('Y-m-d') }}" required>
            @error('check_in_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        @if($reservation->roomType->is_suite)
            <div class="mb-3">
                <label class="form-label">Duration</label>
                <div class="input-group">
                    <input type="number" name="duration_value" class="form-control" min="1" value="{{ $reservation->duration_value }}" required>
                    <select name="duration_type" class="form-control" required>
                        <option value="weeks" {{ $reservation->duration_type == 'weeks' ? 'selected' : '' }}>Weeks</option>
                        <option value="months" {{ $reservation->duration_type == 'months' ? 'selected' : '' }}>Months</option>
                    </select>
                </div>
                <small class="form-text text-muted">Note: A 4-week reservation will be charged at the monthly rate.</small>
                @error('duration_value') <span class="text-danger">{{ $message }}</span> @enderror
                @error('duration_type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        @else
            <div class="mb-3">
                <label class="form-label">Check-out Date</label>
                <input type="date" name="check_out_date" class="form-control" value="{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('Y-m-d') }}" required>
                @error('check_out_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        @endif
        <div class="mb-3">
            <label class="form-label">Number of Occupants (Max {{ $reservation->roomType->max_occupants }})</label>
            <input type="number" name="number_of_occupants" class="form-control" min="1" max="{{ $reservation->roomType->max_occupants }}" value="{{ $reservation->number_of_occupants }}" required>
            @error('number_of_occupants') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Credit Card Details (Optional)</label>
            <input type="text" name="credit_card_details" class="form-control" value="{{ $reservation->credit_card_details }}">
            @error('credit_card_details') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Reservation</button>
    </form>
</div>
@endsection