<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBidStats extends Model
{
    protected $table = 'user_bid_stats';
    protected $fillable = [
        'user_id',
        'instagram',
        'current_bid',
        'buy_bid',
        'bid_spent',
        'income',
    ];
}
