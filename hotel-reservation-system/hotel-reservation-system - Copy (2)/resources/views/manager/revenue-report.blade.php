@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Revenue Report</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Form -->
    <div class="mb-4">
        <form method="GET" action="{{ route('manager.revenue-report') }}">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="date_range" class="form-label">Date Range</label>
                    <input type="text" name="date_range" id="date_range" class="form-control" placeholder="Select date range" value="{{ request('date_range') }}">
                </div>
                <div class="col-md-2 mb-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('manager.revenue-report') }}" class="btn btn-secondary">Clear</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Download Buttons -->
    <div class="mb-4">
        <a href="{{ route('manager.download-revenue-report', ['format' => 'pdf', 'date_range' => request('date_range')]) }}" class="btn btn-primary">Download PDF</a>
        <a href="{{ route('manager.download-revenue-report', ['format' => 'excel', 'date_range' => request('date_range')]) }}" class="btn btn-success">Download Excel</a>
    </div>

    <!-- Reports Table -->
    @if($reports->isEmpty())
        <p>No revenue reports found for the selected criteria.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Revenue ($)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->date }}</td>
                        <td>{{ number_format($report->total_revenue ?? 0, 2) }}</td>
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