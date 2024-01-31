<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationsNews extends Model
{
    protected $table = 'notifications_news';
    protected $fillable = [
        'title',
        'text',
        'image',
        'shown',
    ];
}
