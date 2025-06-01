<?php

namespace App\Http\Controllers;

use App\Exports\OccupancyReportExport;
use App\Exports\ReportsExport;
use App\Exports\RevenueReportExport;
use App\Models\Report;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\RoomType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:manager');
    }

    public function dashboard()
    {
        $reports = Report::where('branch_id', Auth::user()->branch_id)->latest()->take(10)->get();
        return view('manager.dashboard', compact('reports'));
    }

    public function reports(Request $request)
    {
        $query = Report::where('branch_id', Auth::user()->branch_id);

        if ($request->date_range) {
            [$start, $end] = explode(' - ', $request->date_range);
            $query->whereBetween('report_date', [$start, $end]);
        }

        $reports = $query->latest()->get();

        return view('manager.reports', compact('reports'));
    }

    public function downloadReport($date, $format)
    {
        $report = Report::where('branch_id', Auth::user()->branch_id)
                        ->where('report_date', $date)
                        ->firstOrFail();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('manager.daily-report', compact('report'));
            return $pdf->download('daily_report_' . $date . '.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(new ReportsExport($report), 'daily_report_' . $date . '.xlsx');
        }

        abort(400, 'Invalid format');
    }

    public function occupancyReport(Request $request)
    {
        $query = Reservation::where('reservations.branch_id', Auth::user()->branch_id)
                            ->join('billings', 'reservations.id', '=', 'billings.reservation_id')
                            ->with(['roomType', 'user'])
                            ->select('reservations.*', 'billings.total_amount');
        $roomTypes = RoomType::all();

        if ($request->date_range) {
            $request->validate([
                'date_range' => 'required|regex:/^\d{4}-\d{2}-\d{2} - \d{4}-\d{2}-\d{2}$/',
            ]);
            [$start, $end] = explode(' - ', $request->date_range);
            $query->whereBetween('reservations.check_in_date', [$start, $end]);
        }
        if ($request->room_type_id) {
            $query->where('reservations.room_type_id', $request->room_type_id);
        }
        if ($request->status) {
            $query->where('reservations.status', $request->status);
        }

        $reservations = $query->get();

        // Save to reports table
        if ($request->date_range) {
            $startDate = Carbon::parse(explode(' - ', $request->date_range)[0]);
            $endDate = Carbon::parse(explode(' - ', $request->date_range)[1]);
            $dates = [];
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $dates[] = $date->toDateString();
            }

            foreach ($dates as $date) {
                $count = $reservations->where('check_in_date', $date)->count();
                Report::updateOrCreate(
                    [
                        'branch_id' => Auth::user()->branch_id,
                        'report_date' => $date,
                    ],
                    [
                        'total_occupancy' => $count,
                        'no_show_count' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        return view('manager.occupancy-report', compact('reservations', 'roomTypes'));

    }

    public function downloadOccupancyReport(Request $request, $format)
    {
        $query = Reservation::where('reservations.branch_id', Auth::user()->branch_id)
                            ->join('billings', 'reservations.id', '=', 'billings.reservation_id')
                            ->with(['user', 'roomType'])
                            ->select('reservations.*', 'billings.total_amount');
        $roomTypes = RoomType::all();

        if ($request->date_range) {
            $request->validate([
                'date_range' => 'required|regex:/^\d{4}-\d{2}-\d{2} - \d{4}-\d{2}-\d{2}$/',
            ]);
            [$start, $end] = explode(' - ', $request->date_range);
            $query->whereBetween('reservations.check_in_date', [$start, $end]);
        }
        if ($request->room_type_id) {
            $query->where('reservations.room_type_id', $request->room_type_id);
        }
        if ($request->status) {
            $query->where('reservations.status', $request->status);
        }

        $reservations = $query->get();
        $filters = [
            'date_range' => $request->input('date_range') ?? 'All Dates',
            'room_type' => $request->room_type_id && $roomTypes->find($request->room_type_id) ? RoomType::find($request->room_type_id)->name : 'All Room Types',
            'status' => $request->status ?: 'All Statuses',
        ];

        // Save to reports table
        if ($request->date_range) {
            $startDate = Carbon::parse(explode(' - ', $request->date_range)[0]);
            $endDate = Carbon::parse(explode(' - ', $request->date_range)[1]);
            $dates = [];
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $dates[] = $date->toDateString();
            }

            foreach ($dates as $date) {
                $count = $reservations->where('check_in_date', $date)->count();
                Report::updateOrCreate(
                    [
                        'branch_id' => Auth::user()->branch_id,
                        'report_date' => $date,
                    ],
                    [
                        'total_occupancy' => $count,
                        'no_show_count' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('manager.occupancy-report-pdf', compact('reservations', 'filters'));
            return $pdf->download('occupancy_report_' . date('Y-m-d') . '.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(new OccupancyReportExport($reservations), 'occupancy_report_' . date('Y-m-d') . '.xlsx');
        }

        abort(400, 'Invalid format');
    }

    public function revenueReport(Request $request)
    {
        $query = Reservation::where('reservations.branch_id', Auth::user()->branch_id)
                           ->join('billings', 'reservations.id', '=', 'billings.reservation_id')
                           ->select(
                               DB::raw('DATE(reservations.check_in_date) as date'),
                               DB::raw('SUM(billings.total_amount) as total_revenue')
                           )
                           ->groupBy(DB::raw('DATE(reservations.check_in_date)'));

        if ($request->date_range) {
            $request->validate([
                'date_range' => 'required|regex:/^\d{4}-\d{2}-\d{2} - \d{4}-\d{2}-\d{2}$/',
            ]);
            [$start, $end] = explode(' - ', $request->date_range);
            $startDate = Carbon::parse($start)->startOfDay()->toDateString();
            $endDate = Carbon::parse($end)->endOfDay()->toDateString();
            Log::info('Revenue Report Filter', [
                'date_range' => $request->date_range,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'branch_id' => Auth::user()->branch_id,
            ]);
            $query->whereBetween('reservations.check_in_date', [$startDate, $endDate]);

            $sql = $query->toSql();
            $bindings = $query->getBindings();
            Log::info('Revenue Report SQL', [
                'sql' => $sql,
                'bindings' => $bindings,
            ]);
        }

        $reports = $query->orderBy('date', 'desc')->get();

        // Save to reports table
        foreach ($reports as $report) {
            Report::updateOrCreate(
                [
                    'branch_id' => Auth::user()->branch_id,
                    'report_date' => $report->date,
                ],
                [
                    'total_revenue' => $report->total_revenue,
                    'no_show_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        Log::info('Revenue Report Results', [
            'count' => $reports->count(),
            'reports' => $reports->map(function ($report) {
                return [
                    'date' => $report->date,
                    'total_revenue' => $report->total_revenue,
                ];
            })->toArray(),
        ]);

        return view('manager.revenue-report', compact('reports'));
    }

    public function downloadRevenueReport(Request $request, $format)
    {
        $query = Reservation::where('reservations.branch_id', Auth::user()->branch_id)
                           ->join('billings', 'reservations.id', '=', 'billings.reservation_id')
                           ->select(
                               DB::raw('DATE(reservations.check_in_date) as date'),
                               DB::raw('SUM(billings.total_amount) as total_revenue')
                           )
                           ->groupBy(DB::raw('DATE(reservations.check_in_date)'));

        if ($request->date_range) {
            $request->validate([
                'date_range' => 'required|regex:/^\d{4}-\d{2}-\d{2} - \d{4}-\d{2}-\d{2}$/',
            ]);
            [$start, $end] = explode(' - ', $request->date_range);
            $startDate = Carbon::parse($start)->startOfDay()->toDateString();
            $endDate = Carbon::parse($end)->endOfDay()->toDateString();
            Log::info('Download Revenue Report Filter', [
                'date_range' => $request->date_range,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'branch_id' => Auth::user()->branch_id,
            ]);
            $query->whereBetween('reservations.check_in_date', [$startDate, $endDate]);

            $sql = $query->toSql();
            $bindings = $query->getBindings();
            Log::info('Download Revenue Report SQL', [
                'sql' => $sql,
                'bindings' => $bindings,
            ]);
        }

        $reports = $query->orderBy('date', 'desc')->get();

        // Save to reports table
        foreach ($reports as $report) {
            Report::updateOrCreate(
                [
                    'branch_id' => Auth::user()->branch_id,
                    'report_date' => $report->date,
                ],
                [
                    'total_revenue' => $report->total_revenue,
                    'no_show_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        Log::info('Download Revenue Report Results', [
            'count' => $reports->count(),
            'reports' => $reports->map(function ($report) {
                return [
                    'date' => $report->date,
                    'total_revenue' => $report->total_revenue,
                ];
            })->toArray(),
        ]);

        $filters = [
            'date_range' => $request->input('date_range') ?? 'All Dates',
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('manager.revenue-report-pdf', compact('reports', 'filters'));
            return $pdf->download('revenue_report_' . date('Y-m-d') . '.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(new RevenueReportExport($reports), 'revenue_report_' . date('Y-m-d') . '.xlsx');
        }

        abort(400, 'Invalid format');
    }

    public function calendarView()
    {
        $rooms = Room::where('branch_id', Auth::user()->branch_id)->with('roomType')->get();
        $reservations = Reservation::where('branch_id', Auth::user()->branch_id)
                                   ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                                   ->with('roomType')
                                   ->get();
        return view('manager.calendar-view', compact('rooms', 'reservations'));
    }
}