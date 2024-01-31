<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstagramServer extends Model
{
    protected $table = 'instagram_server';
    protected $fillable = [
        'ip',
        'interval',
        'last_request_date',
        'request_count',
        'request_time_wait',
        'off',
        'message',
    ];
}
