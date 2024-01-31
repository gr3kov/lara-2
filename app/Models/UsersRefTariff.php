<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersRefTariff extends Model
{
    protected $table = 'users_ref_tariff';
    protected $fillable = [
        'user_id',
        'ref_tariff_id',
        'active_ref',
        'active_ref_first_level',
        'sum',
        'all_ref'
    ];

    public static function getTariffByUserID($user_id)
    {
        $users_tariff = UsersRefTariff::where('user_id', '=', $user_id)->first();
        if ($users_tariff != null) {
            $tariff = RefTariff::where('id', '=', $users_tariff['ref_tariff_id'])->first();
        } else {
            $tariff = RefTariff::where('id', '=', 1)->first();
        }
        return $tariff;
    }
}
