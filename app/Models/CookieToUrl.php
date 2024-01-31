<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class CookieToUrl extends Model
{
    protected $table = 'cookie_to_url';
    protected $fillable = [
        'cookie',
        'url',
        'target',
        'source',
        'device',
        'host',
    ];
}
