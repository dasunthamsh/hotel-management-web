@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Check Out Reservation #{{ $reservation->id }}</h2>

    <form method="POST" action="{{ route('clerk.check-out', $reservation->id) }}">
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
            <label class="form-label">Base Room Cost</label>
            <input type="text" class="form-control" value="${{ number_format($baseCost, 2) }}" disabled>
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
            <label class="form-label">Restaurant Charges ($)</label>
            <input type="number" name="restaurant_charges" class="form-control charge-input" value="{{ $billing->restaurant_charges ?? 0 }}" min="0" step="0.01">
            @error('restaurant_charges') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Room Service Charges ($)</label>
            <input type="number" name="room_service_charges" class="form-control charge-input" value="{{ $billing->room_service_charges ?? 0 }}" min="0" step="0.01">
            @error('room_service_charges') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Laundry Charges ($)</label>
            <input type="number" name="laundry_charges" class="form-control charge-input" value="{{ $billing->laundry_charges ?? 0 }}" min="0" step="0.01">
            @error('laundry_charges') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Telephone Charges ($)</label>
            <input type="number" name="telephone_charges" class="form-control charge-input" value="{{ $billing->telephone_charges ?? 0 }}" min="0" step="0.01">
            @error('telephone_charges') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Club Facility Charges ($)</label>
            <input type="number" name="club_facility_charges" class="form-control charge-input" value="{{ $billing->club_facility_charges ?? 0 }}" min="0" step="0.01">
            @error('club_facility_charges') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Total Amount ($)</label>
            <input type="text" id="total-amount" class="form-control" value="${{ number_format($baseCost, 2) }}" disabled>
        </div>

        <button type="submit" class="btn btn-primary">Complete Check-out</button>
        <a href="{{ route('clerk.dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const baseCost = {{ $baseCost }};
        const chargeInputs = document.querySelectorAll('.charge-input');
        const totalAmountInput = document.getElementById('total-amount');

        function updateTotal() {
            let additionalCharges = 0;
            chargeInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                additionalCharges += value;
            });
            const total = baseCost + additionalCharges;
            totalAmountInput.value = '$' + total.toFixed(2);
        }

        chargeInputs.forEach(input => {
            input.addEventListener('input', updateTotal);
        });

        // Initial calculation
        updateTotal();
    });
</script>
@endsection
