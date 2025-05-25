<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['branch_id', 'report_date', 'total_occupancy', 'total_revenue', 'no_show_count'];

    protected $casts = [
        'report_date' => 'date',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}