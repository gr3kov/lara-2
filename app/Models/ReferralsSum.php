<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralsSum extends Model
{
    protected $table = 'referrals_sum';
    protected $fillable = [
        'referrals_id',
        'user_id',
        'sum',
    ];
}
