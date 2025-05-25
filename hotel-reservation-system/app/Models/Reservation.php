<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 'branch_id', 'room_id', 'room_type_id', 'check_in_date',
        'check_out_date', 'number_of_occupants', 'status', 'credit_card_details', 'is_suite'
    ];

    protected $casts = [
        'is_suite' => 'boolean',
        'check_in_date' => 'date',
        'check_out_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}