<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class UsersToUrl extends Model
{
    protected $table = 'users_to_url';
    protected $fillable = [
        'url',
        'user_id',
        'target',
        'source',
        'device',
        'host',
    ];
}
