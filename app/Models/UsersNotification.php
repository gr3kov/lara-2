<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersNotification extends Model
{
    protected $table = 'users_notification';
    protected $fillable = [
        'notification_id',
        'user_id',
        'is_show',
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function notification()
    {
        return $this->hasOne('App\Models\Notification', 'id', 'notification_id');
    }
}
