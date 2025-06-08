@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Reserve a Residential Suite</h2>
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
        <input type="hidden" name="is_suite" value="1">
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
        <a href="{{ route('clerk.dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection