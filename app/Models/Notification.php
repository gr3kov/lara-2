<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';
    protected $fillable = [
        'name',
        'title',
        'image',
        'item_id',
        'user_id',
        'type',
        'item_type',
        'already_send',
    ];
}
