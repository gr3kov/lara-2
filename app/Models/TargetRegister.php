<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetRegister extends Model
{
    protected $table = 'target_register';
    protected $fillable = [
        'date',
        'target',
        'host',
        'source', //url
        'visitor',
        'income',
        'active_visitors',
        'register',
        'income_count',
    ];
}
