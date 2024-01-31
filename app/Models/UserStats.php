<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStats extends Model
{
    protected $table = 'user_stats';
    protected $fillable = [
        'all',
        'active',
        'have_insta',
    ];
}
