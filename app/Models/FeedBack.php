<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $table = 'feedback';
    protected $fillable = [
        'user_id',
        'request',
        'response',
        'response_date',
        'active',
    ];
}
