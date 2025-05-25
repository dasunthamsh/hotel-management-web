<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\RoomType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $reports = Report::where('branch_id', Auth::user()->branch_id)->latest()->take(10)->get();
        return view('manager.dashboard', compact('reports'));
    }

    public function occupancyReport(Request $request)
    {
        $query = Reservation::where('branch_id', Auth::user()->branch_id)
                            ->with(['roomType', 'user']);
        $roomTypes = RoomType::all();

        if ($request->date_range) {
            [$start, $end] = explode(' to ', $request->date_range);
            $query->whereBetween('check_in_date', [$start, $end]);
        }
        if ($request->room_type_id) {
            $query->where('room_type_id', $request->room_type_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $reservations = $query->get();
        return view('manager.occupancy-report', compact('reservations', 'roomTypes'));
    }

    public function revenueReport(Request $request)
    {
        $query = Report::where('branch_id', Auth::user()->branch_id);
        if ($request->date_range) {
            [$start, $end] = explode(' to ', $request->date_range);
            $query->whereBetween('report_date', [$start, $end]);
        }
        $reports = $query->get();
        return view('manager.revenue-report', compact('reports'));
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
