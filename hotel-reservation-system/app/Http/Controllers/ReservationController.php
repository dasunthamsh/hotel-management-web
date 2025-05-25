<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\RoomType;
use App\Models\Branch;
use App\Mail\ReservationConfirmation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class ReservationController extends Controller
{
    public function showRoomForm()
    {
        $branches = Branch::all();
        $roomTypes = RoomType::where('is_suite', false)->get();
        return view('customer.reservation-room', compact('branches', 'roomTypes'));
    }

    public function showSuiteForm()
    {
        $branches = Branch::all();
        $roomTypes = RoomType::where('is_suite', true)->get();
        return view('customer.reservation-suite', compact('branches', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_occupants' => 'required|integer|min:1',
            'credit_card_details' => 'nullable|string',
            'is_suite' => 'boolean'
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        $roomType = RoomType::find($data['room_type_id']);
        if ($data['number_of_occupants'] > $roomType->max_occupants) {
            return back()->withErrors(['number_of_occupants' => 'Exceeds maximum occupants']);
        }

        $reservation = Reservation::create($data);
        Mail::to(Auth::user()->email)->send(new ReservationConfirmation($reservation));

        return redirect()->route('customer.reservations')->with('success', 'Reservation created');
    }

    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())->with(['branch', 'roomType'])->get();
        return view('customer.manage-reservations', compact('reservations'));
    }

    public function edit($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);
        $branches = Branch::all();
        $roomTypes = RoomType::where('is_suite', $reservation->is_suite)->get();
        return view('customer.reservation-edit', compact('reservation', 'branches', 'roomTypes'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);
        $data = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_occupants' => 'required|integer|min:1',
            'credit_card_details' => 'nullable|string'
        ]);

        $roomType = RoomType::find($data['room_type_id']);
        if ($data['number_of_occupants'] > $roomType->max_occupants) {
            return back()->withErrors(['number_of_occupants' => 'Exceeds maximum occupants']);
        }

        $reservation->update($data);
        return redirect()->route('customer.reservations')->with('success', 'Reservation updated');
    }

    public function cancel($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);
        if ($reservation->status === 'pending' || $reservation->status === 'confirmed') {
            $reservation->update(['status' => 'cancelled']);
            return redirect()->route('customer.reservations')->with('success', 'Reservation cancelled');
        }
        return back()->withErrors(['status' => 'Cannot cancel this reservation']);
    }
}
