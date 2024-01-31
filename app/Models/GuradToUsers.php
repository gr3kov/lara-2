<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuradToUsers extends Model
{

    protected $table = 'guard_to_users';

    protected $fillable = [
        'user_id',
        'guard_id',
    ];

    public function guard()
    {
        return $this->hasOne('App\Models\ProGuard', 'id', 'guard_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
