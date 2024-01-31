<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveUsers extends Model
{
    protected $table = 'active_users';
    protected $fillable = [
        'per_hour',
        'per_15_min',
        'per_half',
        'today',
    ];
}
