<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersFavorite extends Model
{
    protected $table = 'users_favorite';
    protected $fillable = [
        'user_id',
        'auction_id',
    ];
}
