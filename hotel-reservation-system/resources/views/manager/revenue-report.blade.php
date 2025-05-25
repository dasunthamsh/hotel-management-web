@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Revenue Report</h2>
    <form method="GET" action="{{ route('manager.revenue-report') }}">
        <div class="mb-3">
            <label class="form-label">Date Range</label>
            <input type="text" name="date_range" class="form-control" placeholder="YYYY-MM-DD to YYYY-MM-DD">
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Date</th>
                <th>Occupancy</th>
                <th>Revenue</th>
                <th>No-Shows</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->report_date->format('Y-m-d') }}</td>
                    <td>{{ $report->total_occupancy }}</td>
                    <td>${{ $report->total_revenue }}</td>
                    <td>{{ $report->no_show_count }}</td>
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