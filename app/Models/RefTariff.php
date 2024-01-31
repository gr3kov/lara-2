<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefTariff extends Model
{
    protected $table = 'ref_tariff';
    protected $fillable = [
        'name',
        'description',
        'rate_commission',
        'rate_bonus',
        'min_sum',
        'min_active_ref',
        'min_active_ref_first_level',
        'rate_commission_2',
        'rate_commission_3',
        'rate_bonus_2',
        'rate_bonus_3',
    ];
}
