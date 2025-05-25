@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Travel Agency Booking</h2>
    <form method="POST" action="{{ route('clerk.travel-agency') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Travel Agency</label>
            <select name="travel_agency_id" class="form-control" required>
                @foreach($agencies as $agency)
                    <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                @endforeach
            </select>
            @error('travel_agency_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Branch</label>
            <select name="branch_id" class="form-control" required>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Room Type</label>
            <select name="room_type_id" class="form-control" required>
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
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
            <label class="form-label">Discount Percentage</label>
            <input type="number" name="discount_percentage" class="form-control" min="0" max="100" required>
            @error('discount_percentage') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Quotation Amount</label>
            <input type="number" name="quotation_amount" class="form-control" min="0" step="0.01" required>
            @error('quotation_amount') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Create Booking</button>
    </form>
</div>
@endsection