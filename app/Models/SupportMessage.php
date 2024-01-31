<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $table = 'support_message';
    protected $fillable = [
        'user_id',
        'email',
        'request',
        'response',
        'code',
        'is_send',
        'name',
        'old_support_id',
    ];
}
