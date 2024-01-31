<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidBonus extends Model
{
    protected $table = 'bid_bonus';
    protected $fillable = [
        'user_id',
        'bid_count',
        'code',
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
