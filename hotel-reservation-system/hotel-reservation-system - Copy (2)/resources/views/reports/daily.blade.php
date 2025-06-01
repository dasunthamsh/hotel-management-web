<!DOCTYPE html>
<html>
<head>
    <title>Daily Hotel Report - {{ $data['date'] }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Daily Hotel Report - {{ $data['date'] }}</h1>
    <table>
        <tr>
            <th>Metric</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Occupied Rooms</td>
            <td>{{ $data['occupied_rooms'] }} / {{ $data['total_rooms'] }}</td>
        </tr>
        <tr>
            <td>Occupancy Rate</td>
            <td>{{ $data['occupancy_rate'] }}%</td>
        </tr>
        <tr>
            <td>Revenue</td>
            <td>${{ $data['revenue'] }}</td>
        </tr>
        <tr>
            <td>No-Shows</td>
            <td>{{ $data['no_shows'] }}</td>
        </tr>
    </table>
</body>
</html>