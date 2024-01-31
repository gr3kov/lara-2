<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidDayStats extends Model
{
    protected $table = 'bid_day_stats';
    protected $fillable = [
        'date',
        'income',
        'costs',
        'bid_income',
        'register',
    ];
}
