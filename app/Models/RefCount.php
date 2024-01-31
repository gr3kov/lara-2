<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefCount extends Model
{
    protected $table = 'ref_count';
    protected $fillable = [
        'user_id',
        'user_id_ref',
        'first_sum',
        'pay_at',
    ];
}
