<?php


namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Billing;
use App\Models\TravelAgency;
use App\Models\TravelAgencyBooking;
use App\Mail\PaymentConfirmation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClerkController extends Controller
{
    public function dashboard()
    {
        $reservations = Reservation::where('branch_id', Auth::user()->branch_id)
                                   ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                                   ->with(['user', 'roomType', 'branch'])
                                   ->get();
        return view('clerk.dashboard', compact('reservations'));
    }

    public function checkIn($id)
    {
        $reservation = Reservation::where('branch_id', Auth::user()->branch_id)->findOrFail($id);
        $availableRooms = Room::where('branch_id', Auth::user()->branch_id)
                             ->where('room_type_id', $reservation->room_type_id)
                             ->where('status', 'available')
                             ->get();
        return view('clerk.check-in', compact('reservation', 'availableRooms'));
    }

    public function storeCheckIn(Request $request, $id)
    {
        $reservation = Reservation::where('branch_id', Auth::user()->branch_id)->findOrFail($id);
        $today = Carbon::today()->format('Y-m-d');
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'credit_card_details' => 'required_if:check_in_date,'.$today.'|string|nullable'
        ]);

        $reservation->update([
            'room_id' => $request->room_id,
            'status' => 'checked_in',
            'credit_card_details' => $request->credit_card_details ?? $reservation->credit_card_details
        ]);

        Room::find($request->room_id)->update(['status' => 'occupied']);

        Billing::create([
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'branch_id' => $reservation->branch_id,
            'total_amount' => $this->calculateTotal($reservation)
        ]);

        return redirect()->route('clerk.dashboard')->with('success', 'Check-in completed');
    }

    public function checkOut($id)
    {
        $reservation = Reservation::where('branch_id', Auth::user()->branch_id)->findOrFail($id);
        $billing = Billing::where('reservation_id', $id)->firstOrFail();
        return view('clerk.check-out', compact('reservation', 'billing'));
    }

    public function storeCheckOut(Request $request, $id)
    {
        $reservation = Reservation::where('branch_id', Auth::user()->branch_id)->findOrFail($id);
        $billing = Billing::where('reservation_id', $id)->firstOrFail();
        $request->validate([
            'payment_method' => 'required|in:cash,credit_card',
            'restaurant_charges' => 'nullable|numeric|min:0',
            'room_service_charges' => 'nullable|numeric|min:0',
            'laundry_charges' => 'nullable|numeric|min:0',
            'telephone_charges' => 'nullable|numeric|min:0',
            'club_facility_charges' => 'nullable|numeric|min:0'
        ]);

        $billing->update([
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid',
            'restaurant_charges' => $request->restaurant_charges ?? 0,
            'room_service_charges' => $request->room_service_charges ?? 0,
            'laundry_charges' => $request->laundry_charges ?? 0,
            'telephone_charges' => $request->telephone_charges ?? 0,
            'club_facility_charges' => $request->club_facility_charges ?? 0,
            'total_amount' => $this->calculateTotal($reservation, $request->all())
        ]);

        $reservation->update(['status' => 'checked_out']);
        Room::find($reservation->room_id)->update(['status' => 'available']);

        Mail::to($reservation->user->email)->send(new PaymentConfirmation($billing));

        return redirect()->route('clerk.dashboard')->with('success', 'Check-out completed');
    }

    public function roomAvailability()
    {
        $rooms = Room::where('branch_id', Auth::user()->branch_id)->with('roomType')->get();
        $reservations = Reservation::where('branch_id', Auth::user()->branch_id)
                                   ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                                   ->get();
        return view('clerk.room-availability', compact('rooms', 'reservations'));
    }

    public function travelAgencyBooking()
    {
        $agencies = TravelAgency::where('is_verified', true)->get();
        $roomTypes = RoomType::all();
        $branches = [Auth::user()->branch];
        return view('clerk.travel-agency', compact('agencies', 'roomTypes', 'branches'));
    }

    public function storeTravelAgencyBooking(Request $request)
    {
        $data = $request->validate([
            'travel_agency_id' => 'required|exists:travel_agencies,id',
            'branch_id' => 'required|exists:branches,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_occupants' => 'required|integer|min:1',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'quotation_amount' => 'required|numeric|min:0'
        ]);

        $roomType = RoomType::find($data['room_type_id']);
        if ($data['number_of_occupants'] > $roomType->max_occupants) {
            return back()->withErrors(['number_of_occupants' => 'Exceeds maximum occupants']);
        }

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'branch_id' => $data['branch_id'],
            'room_type_id' => $data['room_type_id'],
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
            'number_of_occupants' => $data['number_of_occupants'],
            'status' => 'confirmed'
        ]);

        TravelAgencyBooking::create([
            'travel_agency_id' => $data['travel_agency_id'],
            'reservation_id' => $reservation->id,
            'discount_percentage' => $data['discount_percentage'],
            'quotation_amount' => $data['quotation_amount']
        ]);

        Billing::create([
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'branch_id' => $reservation->branch_id,
            'total_amount' => $data['quotation_amount'],
            'payment_method' => 'travel_agency',
            'payment_status' => 'pending'
        ]);

        return redirect()->route('clerk.dashboard')->with('success', 'Travel agency booking created');
    }

    private function calculateTotal($reservation, $additionalCharges = [])
    {
        $roomType = $reservation->roomType;
        $days = Carbon::parse($reservation->check_out_date)->diffInDays($reservation->check_in_date);
        $total = $reservation->is_suite
            ? ($roomType->monthly_rate ?? $roomType->weekly_rate)
            : ($roomType->price_per_night * $days);

        foreach (['restaurant_charges', 'room_service_charges', 'laundry_charges', 'telephone_charges', 'club_facility_charges'] as $charge) {
            $total += $additionalCharges[$charge] ?? 0;
        }

        return $total;
    }
}
