<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyToken extends Model
{
    protected $table = 'money_token';
    protected $fillable = [
        'scope',
        'token',
    ];
}
