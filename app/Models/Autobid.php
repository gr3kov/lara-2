<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autobid extends Model
{
    protected $table = 'autobid';
    protected $fillable = [
        'user_id',
        'auction_id',
        'last_time_sec',
        'date_time_start',
        'date_time_stop',
        'active',
        'next_time_sec',
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function auction()
    {
        return $this->hasOne('App\Models\Auction', 'id', 'auction_id');
    }
}
