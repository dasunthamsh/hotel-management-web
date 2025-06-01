<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\RoomType;
use App\Models\Branch;
use App\Mail\ReservationConfirmation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $isSuite = $request->has('is_suite') && $request->is_suite;

        $rules = [
            'branch_id' => 'required|exists:branches,id',
            'room_type_id' => 'required|exists:room_types,id',
            'number_of_occupants' => 'required|integer|min:1',
            'credit_card_details' => 'nullable|string',
        ];

        if ($isSuite) {
            $rules = array_merge($rules, [
                'check_in_date' => 'required|date|after:today',
                'duration_type' => 'required|in:weeks,months',
                'duration_value' => 'required|integer|min:1',
            ]);
        } else {
            $rules = array_merge($rules, [
                'check_in_date' => 'required|date|after:today',
                'check_out_date' => 'required|date|after:check_in_date',
            ]);
        }

        $data = $request->validate($rules);

        $roomType = RoomType::find($data['room_type_id']);
        if ($data['number_of_occupants'] > $roomType->max_occupants) {
            return back()->withErrors(['number_of_occupants' => 'Exceeds maximum occupants']);
        }

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        if ($isSuite) {
            $checkInDate = Carbon::parse($data['check_in_date']);
            if ($data['duration_type'] === 'weeks') {
                if ($data['duration_value'] == 4) {
                    // Treat 4 weeks as 1 month
                    $data['duration_type'] = 'months';
                    $data['duration_value'] = 1;
                    $data['check_out_date'] = $checkInDate->copy()->addMonth()->format('Y-m-d');
                } else {
                    $data['check_out_date'] = $checkInDate->copy()->addWeeks($data['duration_value'])->format('Y-m-d');
                }
            } else {
                $data['check_out_date'] = $checkInDate->copy()->addMonths($data['duration_value'])->format('Y-m-d');
            }
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
        $roomTypes = RoomType::where('is_suite', $reservation->roomType->is_suite)->get();
        return view('customer.reservation-edit', compact('reservation', 'branches', 'roomTypes'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);
        $isSuite = $reservation->roomType->is_suite;

        $rules = [
            'branch_id' => 'required|exists:branches,id',
            'room_type_id' => 'required|exists:room_types,id',
            'number_of_occupants' => 'required|integer|min:1',
            'credit_card_details' => 'nullable|string',
        ];

        if ($isSuite) {
            $rules = array_merge($rules, [
                'check_in_date' => 'required|date|after:today',
                'duration_type' => 'required|in:weeks,months',
                'duration_value' => 'required|integer|min:1',
            ]);
        } else {
            $rules = array_merge($rules, [
                'check_in_date' => 'required|date|after:today',
                'check_out_date' => 'required|date|after:check_in_date',
            ]);
        }

        $data = $request->validate($rules);

        $roomType = RoomType::find($data['room_type_id']);
        if ($data['number_of_occupants'] > $roomType->max_occupants) {
            return back()->withErrors(['number_of_occupants' => 'Exceeds maximum occupants']);
        }

        if ($isSuite) {
            $checkInDate = Carbon::parse($data['check_in_date']);
            if ($data['duration_type'] === 'weeks') {
                if ($data['duration_value'] == 4) {
                    $data['duration_type'] = 'months';
                    $data['duration_value'] = 1;
                    $data['check_out_date'] = $checkInDate->copy()->addMonth()->format('Y-m-d');
                } else {
                    $data['check_out_date'] = $checkInDate->copy()->addWeeks($data['duration_value'])->format('Y-m-d');
                }
            } else {
                $data['check_out_date'] = $checkInDate->copy()->addMonths($data['duration_value'])->format('Y-m-d');
            }
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