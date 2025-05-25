@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Occupancy Report</h2>
    <form method="GET" action="{{ route('manager.occupancy-report') }}">
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Date Range</label>
                <input type="text" name="date_range" class="form-control" placeholder="YYYY-MM-DD to YYYY-MM-DD">
            </div>
            <div class="col-md-4">
                <label class="form-label">Room Type</label>
                <select name="room_type_id" class="form-control">
                    <option value="">All</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="checked_in">Checked In</option>
                    <option value="checked_out">Checked Out</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Room Type</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->roomType->name }}</td>
                    <td>{{ $reservation->check_in_date->format('Y-m-d') }}</td>
                    <td>{{ $reservation->check_out_date->format('Y-m-d') }}</td>
                    <td>{{ $reservation->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet">
<script>
    $('input[name="date_range"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
</script>
@endsection