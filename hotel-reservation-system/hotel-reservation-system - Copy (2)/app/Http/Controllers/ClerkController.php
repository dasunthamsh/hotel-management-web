<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Billing;
use App\Models\TravelAgency;
use App\Models\TravelAgencyBooking;
use App\Models\RoomType;
use App\Mail\PaymentConfirmation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ClerkController extends Controller
{
    public function dashboard()
    {
        $branchId = Auth::user()->branch_id;

        // Fetch individual reservations (not linked to travel agency bookings)
        $reservations = Reservation::where('branch_id', $branchId)
            ->whereNotIn('id', TravelAgencyBooking::pluck('reservation_id'))
            ->where(function ($query) {
                $query->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('status', 'checked_out')
                            ->where('updated_at', '>=', Carbon::now()->subHours(24));
                    });
            })
            ->with(['user', 'roomType', 'branch'])
            ->get();

        // Fetch travel agency bookings with their reservations
        $travelAgencyBookings = TravelAgencyBooking::whereHas('reservation', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId)
                    ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('status', 'checked_out')
                            ->where('updated_at', '>=', Carbon::now()->subHours(24));
                    });
            })
            ->with(['travelAgency', 'reservation' => function ($query) {
                $query->with(['user', 'roomType', 'branch']);
            }])
            ->get()
            ->groupBy('travel_agency_id');

        Log::info('Clerk Dashboard Data', [
            'branch_id' => $branchId,
            'individual_reservations_count' => $reservations->count(),
            'travel_agency_bookings_count' => $travelAgencyBookings->count(),
            'statuses' => $reservations->pluck('status')->unique()->toArray(),
            'checked_out' => $reservations->where('status', 'checked_out')->map(function ($res) {
                return [
                    'id' => $res->id,
                    'updated_at' => $res->updated_at->toDateTimeString(),
                    'within_24h' => $res->updated_at >= Carbon::now()->subHours(24)
                ];
            })->toArray()
        ]);

        return view('clerk.dashboard', compact('reservations', 'travelAgencyBookings'));
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
            'total_amount' => $this->calculateTotal($reservation),
            'payment_status' => 'pending'
        ]);

        return redirect()->route('clerk.dashboard')->with('success', 'Check-in completed');
    }

    public function checkOut($id)
    {
        $reservation = Reservation::where('branch_id', Auth::user()->branch_id)->findOrFail($id);
        $billing = Billing::where('reservation_id', $id)->firstOrFail();
        $baseCost = $this->calculateTotal($reservation);
        return view('clerk.check-out', compact('reservation', 'billing', 'baseCost'));
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

    public function editCheckOut($id)
    {
        $reservation = Reservation::where('branch_id', Auth::user()->branch_id)
                                  ->where('status', 'checked_out')
                                  ->where('updated_at', '>=', Carbon::now()->subHours(24))
                                  ->findOrFail($id);
        $billing = Billing::where('reservation_id', $id)->firstOrFail();
        $baseCost = $this->calculateTotal($reservation);
        return view('clerk.edit-check-out', compact('reservation', 'billing', 'baseCost'));
    }

    public function updateCheckOut(Request $request, $id)
    {
        $reservation = Reservation::where('branch_id', Auth::user()->branch_id)
                                  ->where('status', 'checked_out')
                                  ->where('updated_at', '>=', Carbon::now()->subHours(24))
                                  ->findOrFail($id);
        $billing = Billing::where('reservation_id', $id)->firstOrFail();
        $request->validate([
            'payment_method' => 'required|in:cash,credit_card',
            'payment_status' => 'required|in:pending,paid',
            'restaurant_charges' => 'nullable|numeric|min:0',
            'room_service_charges' => 'nullable|numeric|min:0',
            'laundry_charges' => 'nullable|numeric|min:0',
            'telephone_charges' => 'nullable|numeric|min:0',
            'club_facility_charges' => 'nullable|numeric|min:0'
        ]);

        $billing->update([
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
            'restaurant_charges' => $request->restaurant_charges ?? 0,
            'room_service_charges' => $request->room_service_charges ?? 0,
            'laundry_charges' => $request->laundry_charges ?? 0,
            'telephone_charges' => $request->telephone_charges ?? 0,
            'club_facility_charges' => $request->club_facility_charges ?? 0,
            'total_amount' => $this->calculateTotal($reservation, $request->all())
        ]);

        if ($billing->payment_status === 'paid') {
            Mail::to($reservation->user->email)->send(new PaymentConfirmation($billing));
        }

        return redirect()->route('clerk.dashboard')->with('success', 'Checkout updated successfully');
    }

    public function roomAvailability()
    {
        $branchId = Auth::user()->branch_id;

        $rooms = Room::where('branch_id', $branchId)
                     ->with('roomType')
                     ->get();

        $reservations = Reservation::where('branch_id', $branchId)
                                   ->whereIn('status', ['confirmed', 'checked_in'])
                                   ->with(['user', 'room', 'roomType'])
                                   ->get();

        $checkedInRooms = [];
        $availableRooms = [];

        foreach ($rooms as $room) {
            $reservation = $reservations->firstWhere('room_id', $room->id);
            if ($reservation && $reservation->status === 'checked_in') {
                $checkedInRooms[] = [
                    'room' => $room,
                    'reservation' => $reservation,
                    'customer' => $reservation->user->name,
                    'check_in_date' => $reservation->check_in_date,
                    'check_out_date' => $reservation->check_out_date
                ];
            } elseif (!$reservation && $room->status === 'available') {
                $availableRooms[] = [
                    'room' => $room,
                    'room_type' => $room->roomType->name
                ];
            }
        }

        return view('clerk.room-availability', compact('checkedInRooms', 'availableRooms'));
    }

    public function travelAgencyBooking()
    {
        $agencies = TravelAgency::where('is_verified', true)->get();
        $roomTypes = RoomType::all();
        $branches = [Auth::user()->branch];

        $roomGroups = [
            'single' => $roomTypes->where('max_occupants', 1)->where('is_suite', 0),
            'double' => $roomTypes->where('max_occupants', 2)->where('is_suite', 0),
            'suite' => $roomTypes->where('is_suite', 1)
        ];

        return view('clerk.travel-agency', compact('agencies', 'roomGroups', 'branches'));
    }

    public function storeTravelAgencyBooking(Request $request)
    {
        try {
            // Log incoming request data
            Log::info('Travel Agency Booking Request', $request->all());

            // Base validation rules
            $baseRules = [
                'travel_agency_id' => 'required|exists:travel_agencies,id',
                'branch_id' => 'required|exists:branches,id',
                'room_types' => 'required|array|min:1',
                'room_types.*.selected' => 'nullable|boolean',
                'room_types.*.quantity' => 'required_if:room_types.*.selected,1|integer|min:1',
                'room_types.*.occupants' => 'required_if:room_types.*.selected,1|integer|min:1',
                'room_types.*.check_in_date' => 'required_if:room_types.*.selected,1|date|after_or_equal:today',
                'discount_percentage' => 'required|numeric|min:0|max:100',
                'quotation_amount' => 'required|numeric|min:0'
            ];

            // Dynamic validation rules based on room type
            $roomTypes = RoomType::all()->keyBy('id');
            $dynamicRules = [];

            foreach ($request->input('room_types', []) as $roomTypeId => $roomData) {
                if (isset($roomData['selected']) && $roomData['selected']) {
                    $isSuite = isset($roomTypes[$roomTypeId]) && $roomTypes[$roomTypeId]->is_suite;
                    if ($isSuite) {
                        $dynamicRules["room_types.{$roomTypeId}.duration_value"] = 'required|integer|min:1';
                        $dynamicRules["room_types.{$roomTypeId}.duration_type"] = 'required|in:weeks,months';
                        $dynamicRules["room_types.{$roomTypeId}.check_out_date"] = 'nullable';
                    } else {
                        $dynamicRules["room_types.{$roomTypeId}.check_out_date"] = 'required|date|after:room_types.*.check_in_date';
                        $dynamicRules["room_types.{$roomTypeId}.duration_value"] = 'nullable';
                        $dynamicRules["room_types.{$roomTypeId}.duration_type"] = 'nullable';
                    }
                } else {
                    $dynamicRules["room_types.{$roomTypeId}.check_out_date"] = 'nullable';
                    $dynamicRules["room_types.{$roomTypeId}.duration_value"] = 'nullable';
                    $dynamicRules["room_types.{$roomTypeId}.duration_type"] = 'nullable';
                }
            }

            // Merge base and dynamic rules
            $rules = array_merge($baseRules, $dynamicRules);

            // Validate request data
            $data = $request->validate($rules);

            Log::info('Travel Agency Booking Validation Passed', [
                'travel_agency_id' => $data['travel_agency_id'],
                'branch_id' => $data['branch_id'],
                'room_types' => $data['room_types'],
                'discount_percentage' => $data['discount_percentage'],
                'quotation_amount' => $data['quotation_amount']
            ]);

            // Calculate total rooms
            $totalRooms = 0;
            $selectedRoomTypes = [];
            foreach ($data['room_types'] as $roomTypeId => $roomData) {
                if (isset($roomData['selected']) && $roomData['selected'] && !empty($roomData['quantity'])) {
                    $totalRooms += (int)$roomData['quantity'];
                    $selectedRoomTypes[$roomTypeId] = $roomData;
                }
            }

            if ($totalRooms < 3) {
                Log::warning('Travel Agency Booking Failed: Insufficient Rooms', ['total_rooms' => $totalRooms]);
                return back()->withErrors(['room_types' => 'A minimum of 3 rooms total is required.'])->withInput();
            }

            // Validate room types and availability
            foreach ($selectedRoomTypes as $roomTypeId => $roomData) {
                $roomType = RoomType::find($roomTypeId);
                if (!$roomType) {
                    Log::warning('Travel Agency Booking Failed: Invalid Room Type', ['room_type_id' => $roomTypeId]);
                    return back()->withErrors(["room_types.{$roomTypeId}" => 'Invalid room type selected.'])->withInput();
                }

                if ($roomData['occupants'] > $roomType->max_occupants) {
                    Log::warning('Travel Agency Booking Failed: Occupants Exceed Limit', [
                        'room_type_id' => $roomTypeId,
                        'occupants' => $roomData['occupants'],
                        'max_occupants' => $roomType->max_occupants
                    ]);
                    return back()->withErrors(["room_types.{$roomTypeId}.occupants" => "Number of occupants exceeds maximum for {$roomType->name}."])->withInput();
                }

                if ($roomType->is_suite && $roomData['quantity'] > 3) {
                    Log::warning('Travel Agency Booking Failed: Suite Quantity Exceeds Limit', [
                        'room_type_id' => $roomTypeId,
                        'quantity' => $roomData['quantity']
                    ]);
                    return back()->withErrors(["room_types.{$roomTypeId}.quantity" => "Maximum 3 rooms allowed per booking for {$roomType->name}."])->withInput();
                }

                $availableRooms = Room::where('branch_id', $data['branch_id'])
                                     ->where('room_type_id', $roomTypeId)
                                     ->where('status', 'available')
                                     ->count();
                if ($availableRooms < $roomData['quantity']) {
                    Log::warning('Travel Agency Booking Failed: Insufficient Available Rooms', [
                        'room_type_id' => $roomTypeId,
                        'available' => $availableRooms,
                        'requested' => $roomData['quantity']
                    ]);
                    return back()->withErrors(["room_types.{$roomTypeId}.quantity" => "Not enough available rooms for {$roomType->name}."])->withInput();
                }
            }

            // Start transaction
            DB::beginTransaction();

            try {
                $reservations = [];
                $totalQuotationPerRoom = $data['quotation_amount'] / $totalRooms;

                foreach ($selectedRoomTypes as $roomTypeId => $roomData) {
                    $roomType = RoomType::findOrFail($roomTypeId);
                    $checkOutDate = $roomData['check_out_date'] ?? null;

                    if ($roomType->is_suite) {
                        $checkInDate = Carbon::parse($roomData['check_in_date']);
                        if ($roomData['duration_type'] === 'weeks') {
                            if ($roomData['duration_value'] == 4) {
                                $roomData['duration_type'] = 'months';
                                $roomData['duration_value'] = 1;
                                $checkOutDate = $checkInDate->copy()->addMonth()->format('Y-m-d');
                            } else {
                                $checkOutDate = $checkInDate->copy()->addWeeks($roomData['duration_value'])->format('Y-m-d');
                            }
                        } else {
                            $checkOutDate = $checkInDate->copy()->addMonths($roomData['duration_value'])->format('Y-m-d');
                        }
                    }

                    for ($i = 0; $i < $roomData['quantity']; $i++) {
                        // Create reservation
                        $reservation = Reservation::create([
                            'user_id' => Auth::id(),
                            'branch_id' => $data['branch_id'],
                            'room_type_id' => $roomTypeId,
                            'check_in_date' => $roomData['check_in_date'],
                            'check_out_date' => $checkOutDate,
                            'number_of_occupants' => $roomData['occupants'],
                            'status' => 'pending', // Allow check-in for pending
                            'duration_type' => $roomType->is_suite ? $roomData['duration_type'] : null,
                            'duration_value' => $roomType->is_suite ? $roomData['duration_value'] : null,
                        ]);

                        Log::info('Reservation Created', [
                            'reservation_id' => $reservation->id,
                            'room_type_id' => $roomTypeId,
                            'quantity' => $roomData['quantity'],
                            'check_out_date' => $checkOutDate
                        ]);

                        // Create travel agency booking
                        $travelAgencyBooking = TravelAgencyBooking::create([
                            'travel_agency_id' => $data['travel_agency_id'],
                            'reservation_id' => $reservation->id,
                            'discount_percentage' => $data['discount_percentage'],
                            'quotation_amount' => $totalQuotationPerRoom
                        ]);

                        Log::info('Travel Agency Booking Created', [
                            'travel_agency_booking_id' => $travelAgencyBooking->id,
                            'reservation_id' => $reservation->id,
                            'travel_agency_id' => $data['travel_agency_id'],
                            'quotation_amount' => $totalQuotationPerRoom
                        ]);

                        // Create billing record
                        Billing::create([
                            'reservation_id' => $reservation->id,
                            'user_id' => $reservation->user_id,
                            'branch_id' => $data['branch_id'],
                            'total_amount' => $totalQuotationPerRoom,
                            'payment_method' => 'travel_agency',
                            'payment_status' => 'pending'
                        ]);

                        $reservations[] = $reservation;
                    }
                }

                DB::commit();

                Log::info('Travel Agency Booking Completed', [
                    'total_rooms' => $totalRooms,
                    'reservations_count' => count($reservations)
                ]);

                return redirect()->route('clerk.dashboard')->with('success', 'Travel agency booking for ' . $totalRooms . ' rooms created successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Travel Agency Booking Failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->withErrors(['error' => 'Failed to create booking: ' . $e->getMessage()])->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Travel Agency Booking Validation Failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Unexpected Error in Travel Agency Booking', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()])->withInput();
        }
    }

    private function calculateTotal($reservation, $additionalCharges = [])
    {
        $roomType = $reservation->roomType;
        $total = 0;

        if ($roomType->is_suite) {
            if ($reservation->duration_type === 'weeks') {
                $total = $roomType->weekly_rate * $reservation->duration_value;
            } elseif ($reservation->duration_type === 'months') {
                $total = $roomType->monthly_rate * $reservation->duration_value;
            }
        } else {
            $days = Carbon::parse($reservation->check_out_date)->diffInDays(Carbon::parse($reservation->check_in_date));
            $total = $roomType->price_per_night * $days;
        }

        foreach (['restaurant_charges', 'room_service_charges', 'laundry_charges', 'telephone_charges', 'club_facility_charges'] as $charge) {
            $total += $additionalCharges[$charge] ?? 0;
        }

        return $total;
    }

    private function calculateSuiteDuration($checkInDate, $checkOutDate)
    {
        $checkIn = Carbon::parse($checkInDate);
        $checkOut = Carbon::parse($checkOutDate);
        $days = $checkOut->diffInDays($checkIn);

        $weeks = floor($days / 7);
        if ($weeks >= 4) {
            $months = floor($weeks / 4);
            return $months;
        }

        return $weeks;
    }
}