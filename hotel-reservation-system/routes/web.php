<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ClerkController;
use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Customer Routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('reservations/room', [ReservationController::class, 'showRoomForm'])->name('reservations.room');
    Route::get('reservations/suite', [ReservationController::class, 'showSuiteForm'])->name('reservations.suite');
    Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('reservations', [ReservationController::class, 'index'])->name('customer.reservations');
    Route::get('reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('reservations/{id}', [ReservationController::class, 'cancel'])->name('reservations.cancel');
});

// Clerk Routes
Route::middleware(['auth', 'role:clerk'])->prefix('clerk')->group(function () {
    Route::get('dashboard', [ClerkController::class, 'dashboard'])->name('clerk.dashboard');
    Route::get('check-in/{id}', [ClerkController::class, 'checkIn'])->name('clerk.check-in');
    Route::post('check-in/{id}', [ClerkController::class, 'storeCheckIn']);
    Route::get('check-out/{id}', [ClerkController::class, 'checkOut'])->name('clerk.check-out');
    Route::post('check-out/{id}', [ClerkController::class, 'storeCheckOut']);
    Route::get('room-availability', [ClerkController::class, 'roomAvailability'])->name('clerk.room-availability');
    Route::get('travel-agency', [ClerkController::class, 'travelAgencyBooking'])->name('clerk.travel-agency');
    Route::post('travel-agency', [ClerkController::class, 'storeTravelAgencyBooking']);
});

// Manager Routes
Route::middleware(['auth', 'role:manager'])->prefix('manager')->group(function () {
    Route::get('dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    Route::get('occupancy-report', [ManagerController::class, 'occupancyReport'])->name('manager.occupancy-report');
    Route::get('revenue-report', [ManagerController::class, 'revenueReport'])->name('manager.revenue-report');
    Route::get('calendar-view', [ManagerController::class, 'calendarView'])->name('manager.calendar-view');
});

// routes/web.php
Route::get('/test-email', function () {
    \Illuminate\Support\Facades\Mail::raw('Test email from Hotel Reservation System', function ($message) {
        $message->to('test@yourapp.local')
                ->subject('Test Email');
    });
    return 'Email sent!';
});

// Dashboard Route (Redirect based on role)
Route::get('dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'customer') {
        return redirect()->route('customer.reservations');
    } elseif ($role === 'clerk') {
        return redirect()->route('clerk.dashboard');
    } elseif ($role === 'manager') {
        return redirect()->route('manager.dashboard');
    }
})->middleware('auth')->name('dashboard');