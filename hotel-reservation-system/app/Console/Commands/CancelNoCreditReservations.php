<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Models\Billing;
use App\Models\Report;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CancelNoCreditReservations extends Command
{
    protected $signature = 'reservations:cancel-no-credit';
    protected $description = 'Cancel reservations without credit card details and process no-shows';

    public function handle()
    {
        $today = Carbon::today();

        // Cancel reservations without credit card details at 7 PM
        $reservations = Reservation::whereNull('credit_card_details')
                                   ->where('check_in_date', $today)
                                   ->where('status', 'pending')
                                   ->get();
        foreach ($reservations as $reservation) {
            $reservation->update(['status' => 'cancelled']);
        }

        // Process no-shows and generate billing
        $noShowReservations = Reservation::where('check_in_date', $today)
                                         ->where('status', 'pending')
                                         ->get();
        foreach ($noShowReservations as $reservation) {
            $reservation->update(['status' => 'no_show']);
            Billing::create([
                'reservation_id' => $reservation->id,
                'user_id' => $reservation->user_id,
                'branch_id' => $reservation->branch_id,
                'total_amount' => $reservation->roomType->price_per_night,
                'payment_status' => 'no_show'
            ]);
        }

        // Generate daily report
        $branches = \App\Models\Branch::all();
        foreach ($branches as $branch) {
            $occupancy = Reservation::where('branch_id', $branch->id)
                                    ->where('check_in_date', '<=', $today)
                                    ->where('check_out_date', '>=', $today)
                                    ->where('status', 'checked_in')
                                    ->count();
            $revenue = Billing::where('branch_id', $branch->id)
                              ->whereDate('created_at', $today)
                              ->sum('total_amount');
            $noShows = Billing::where('branch_id', $branch->id)
                              ->where('payment_status', 'no_show')
                              ->whereDate('created_at', $today)
                              ->count();
            Report::create([
                'branch_id' => $branch->id,
                'report_date' => $today,
                'total_occupancy' => $occupancy,
                'total_revenue' => $revenue,
                'no_show_count' => $noShows
            ]);
        }

        $this->info('Reservations processed successfully');
    }
}