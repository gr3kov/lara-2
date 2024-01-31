<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBidAdd extends Model
{
    protected $table = 'users_bid_add';
    protected $fillable = [
        'user_id',
        'bid',
        'success',
        'shop_id',
        'price',
    ];

    public function shop()
    {
        return $this->hasOne('App\Models\Shop', 'id', 'shop_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
