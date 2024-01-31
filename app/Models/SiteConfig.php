<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteConfig extends Model
{
    protected $table = 'config';
    protected $fillable = [
        'code',
        'name',
        'value',
    ];
}
