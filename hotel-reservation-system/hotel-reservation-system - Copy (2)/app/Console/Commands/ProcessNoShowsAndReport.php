<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Billing;
use App\Models\Room;
use App\Mail\DailyManagerReport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessNoShowsAndReport extends Command
{
    protected $signature = 'reservations:process-no-shows-and-report';
    protected $description = 'Process no-show reservations and generate daily manager report at 7:00 PM';

    public function handle()
    {
        try {
            $yesterday = Carbon::yesterday()->format('Y-m-d');
            $today = Carbon::today()->format('Y-m-d');

            // Process no-show reservations
            $noShowReservations = Reservation::where('status', 'confirmed')
                ->where('check_in_date', $yesterday)
                ->with(['roomType', 'user', 'branch'])
                ->get();

            foreach ($noShowReservations as $reservation) {
                if (!$reservation->roomType) {
                    Log::warning("No room type for reservation ID {$reservation->id}");
                    continue;
                }

                // Calculate base cost
                $baseCost = $this->calculateTotal($reservation);

                // Create billing record
                Billing::create([
                    'reservation_id' => $reservation->id,
                    'user_id' => $reservation->user_id,
                    'branch_id' => $reservation->branch_id,
                    'total_amount' => $baseCost,
                    'payment_method' => 'credit_card',
                    'payment_status' => 'pending',
                    'restaurant_charges' => 0,
                    'room_service_charges' => 0,
                    'laundry_charges' => 0,
                    'telephone_charges' => 0,
                    'club_facility_charges' => 0,
                ]);

                // Update reservation status
                $reservation->update(['status' => 'no_show']);
            }

            // Calculate occupancy for previous night
            $occupiedRooms = Room::where('status', 'occupied')
                ->whereHas('reservations', function ($query) use ($yesterday) {
                    $query->where('check_in_date', '<=', $yesterday)
                          ->where('check_out_date', '>', $yesterday)
                          ->where('status', 'checked_in');
                })
                ->count();

            $totalRooms = Room::count();
            $occupancyRate = $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0;

            // Calculate revenue from previous night's check-outs
            $revenue = Billing::whereHas('reservation', function ($query) use ($yesterday) {
                    $query->where('check_out_date', $yesterday)
                          ->where('status', 'checked_out');
                })
                ->where('payment_status', 'paid')
                ->sum('total_amount');

            // Prepare data for report
            $data = [
                'date' => $yesterday,
                'occupied_rooms' => $occupiedRooms,
                'total_rooms' => $totalRooms,
                'occupancy_rate' => number_format($occupancyRate, 2),
                'revenue' => number_format($revenue, 2),
                'no_shows' => $noShowReservations->count(),
                'pdfPath' => 'reports/daily_report_' . $yesterday . '.pdf',
            ];

            // Generate PDF
            $pdf = Pdf::loadView('reports.daily', compact('data'));
            $pdfPath = $data['pdfPath'];
            Storage::put($pdfPath, $pdf->output());

            // Email report to manager
            $managers = \App\Models\User::where('role', 'manager')->get();
            if ($managers->isEmpty()) {
                Log::warning('No managers found to send daily report');
            } else {
                foreach ($managers as $manager) {
                    Mail::to($manager->email)->send(new DailyManagerReport($data, $pdfPath));
                }
            }

            $this->info('No-show billing and daily report processed for ' . $yesterday);
        } catch (\Exception $e) {
            Log::error('Error in ProcessNoShowsAndReport: ' . $e->getMessage());
            $this->error('Failed to process no-shows and report: ' . $e->getMessage());
        }
    }

    private function calculateTotal($reservation)
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

        return $total;
    }
}