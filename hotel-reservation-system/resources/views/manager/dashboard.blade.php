@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Manager Dashboard ({{ Auth::user()->branch->name }})</h2>
    <div class="mb-3">
        <a href="{{ route('manager.occupancy-report') }}" class="btn btn-primary">Occupancy Report</a>
        <a href="{{ route('manager.revenue-report') }}" class="btn btn-primary">Revenue Report</a>
        <a href="{{ route('manager.calendar-view') }}" class="btn btn-primary">Calendar View</a>
    </div>
    <h3>Recent Reports</h3>
    <table class="table">
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
@endsection