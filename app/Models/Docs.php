<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docs extends Model
{
    protected $table = 'docs';
    protected $fillable = [
        'code',
        'description',
    ];
}
