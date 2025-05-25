<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\TravelAgency;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Branches
        $branches = [
            ['name' => 'Colombo Branch', 'address' => '123 Galle Road, Colombo', 'contact_number' => '0112345678'],
            ['name' => 'Kandy Branch', 'address' => '456 Peradeniya Road, Kandy', 'contact_number' => '0812345678'],
        ];
        foreach ($branches as $branch) {
            Branch::firstOrCreate(['name' => $branch['name']], $branch);
        }

        // Users
        $users = [
            [
                'name' => 'Customer One',
                'email' => 'customer@hotel.com',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'nationality' => 'Sri Lankan',
                'contact_number' => '0771234567',
            ],
            [
                'name' => 'Clerk Colombo',
                'email' => 'clerk@hotel.com',
                'password' => bcrypt('password'),
                'role' => 'clerk',
                'branch_id' => 1,
                'nationality' => 'Sri Lankan',
                'contact_number' => '0771234568',
            ],
            [
                'name' => 'Manager Colombo',
                'email' => 'manager@hotel.com',
                'password' => bcrypt('password'),
                'role' => 'manager',
                'branch_id' => 1,
                'nationality' => 'Sri Lankan',
                'contact_number' => '0771234569',
            ],
        ];
        foreach ($users as $user) {
            User::firstOrCreate(['email' => $user['email']], $user);
        }

        // Room Types
        $roomTypes = [
            ['name' => 'Single Room', 'description' => 'Cozy single room', 'price_per_night' => 50, 'max_occupants' => 1, 'is_suite' => false],
            ['name' => 'Double Room', 'description' => 'Spacious double room', 'price_per_night' => 80, 'max_occupants' => 2, 'is_suite' => false],
            ['name' => 'Executive Suite', 'description' => 'Luxury suite', 'weekly_rate' => 1000, 'monthly_rate' => 3500, 'max_occupants' => 4, 'is_suite' => true],
        ];
        foreach ($roomTypes as $type) {
            RoomType::firstOrCreate(['name' => $type['name']], $type);
        }

        // Rooms
        $rooms = [
            ['branch_id' => 1, 'room_type_id' => 1, 'room_number' => '101', 'status' => 'available'],
            ['branch_id' => 1, 'room_type_id' => 1, 'room_number' => '102', 'status' => 'available'],
            ['branch_id' => 1, 'room_type_id' => 2, 'room_number' => '201', 'status' => 'available'],
            ['branch_id' => 1, 'room_type_id' => 3, 'room_number' => '301', 'status' => 'available'],
        ];
        foreach ($rooms as $room) {
            Room::firstOrCreate(['room_number' => $room['room_number'], 'branch_id' => $room['branch_id']], $room);
        }

        // Travel Agencies
        TravelAgency::firstOrCreate(
            ['name' => 'TravelEasy'],
            [
                'name' => 'TravelEasy',
                'contact_email' => 'contact@traveleasy.com',
                'contact_number' => '0119876543',
                'is_verified' => true,
            ]
        );
    }
}