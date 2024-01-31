<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProGuard extends Model
{
    protected $table = 'pro_guard';

    protected $fillable = [
        'auction_id',
        'user_id_arr',
        'guard',
        'from',
        'to',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'guard_to_users', 'guard_id', 'user_id');
    }
}
