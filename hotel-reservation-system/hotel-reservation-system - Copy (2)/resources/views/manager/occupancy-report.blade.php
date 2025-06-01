@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Occupancy Report</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Form -->
    <div class="mb-4">
        <form method="GET" action="{{ route('manager.occupancy-report') }}">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="date_range" class="form-label">Date Range</label>
                    <input type="text" name="date_range" id="date_range" class="form-control" placeholder="Select date range" value="{{ request('date_range') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="room_type_id" class="form-label">Room Type</label>
                    <select name="room_type_id" id="room_type_id" class="form-control">
                        <option value="">All Room Types</option>
                        @foreach($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}" {{ request('room_type_id') == $roomType->id ? 'selected' : '' }}>{{ $roomType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                        <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('manager.occupancy-report') }}" class="btn btn-secondary">Clear</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Download Buttons -->
    <div class="mb-4">
        <a href="{{ route('manager.download-occupancy-report', ['format' => 'pdf', 'date_range' => request('date_range'), 'room_type_id' => request('room_type_id'), 'status' => request('status')]) }}" class="btn btn-primary">Download PDF</a>
        <a href="{{ route('manager.download-occupancy-report', ['format' => 'excel', 'date_range' => request('date_range'), 'room_type_id' => request('room_type_id'), 'status' => request('status')]) }}" class="btn btn-success">Download Excel</a>
    </div>

    <!-- Reservations Table -->
    @if($reservations->isEmpty())
        <p>No reservations found for the selected criteria.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Guest Name</th>
                    <th>Room Type</th>
                    <th>Check-In Date</th>
                    <th>Check-Out Date</th>
                    <th>Status</th>
                    <th>Total Price ($)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->roomType->name }}</td>
                        <td>{{ $reservation->check_in_date->format('Y-m-d') }}</td>
                        <td>{{ $reservation->check_out_date->format('Y-m-d') }}</td>
                        <td>{{ ucfirst($reservation->status) }}</td>
                        <td>{{ number_format($reservation->total_amount ?? 0, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- DateRangePicker Dependencies -->
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(function() {
    $('#date_range').daterangepicker({
        opens: 'left',
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
});
</script>
@endsection