<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidStats extends Model
{
    protected $table = 'bid_stats';
    protected $fillable = [
        'all_bids',
        'all_price',
        'bonus_bids',
        'costs',
        'bid_costs',
    ];
}
