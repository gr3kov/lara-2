<?php

namespace App;

use App\Models\ReferralsSum;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JetBrains\PhpStorm\NoReturn;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'confirmation_code',
        'confirmed',
        'referrals_id',
        'news_subs',
        'is_send_conf',
        'active',
        'instagram',
        'agreement',
        'personal_data',
        'bid',
        'photo',
        'ref_code',

        'mailing',
        'autobid_notification',
        'news_notification',

        'delivery_name',
        'delivery_post_index',
        'delivery_city',
        'delivery_street',
        'delivery_house',
        'delivery_apartment',
        'delivery_phone',
        'delivery_email',

        'reg_ip',
        'is_ban',
        'instagram_id',

        'firstname',
        'patronymic',
        'lastname',

        'phone',

        'show_notifications',
        'notification_count',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRefAcive($user)
    {
        $activeObj = User::where('referrals_id', '=', $user->id)
            ->where('active', '=', 1)->get();
        return count($activeObj);
    }

    public function getRefReg($user)
    {
        $regObj = User::where('referrals_id', '=', $user->id)->get();
        return count($regObj);
    }

    public static function jumpInc($ref)
    {
        $user = User::where('name', '=', $ref)->first();
        if ($user != null) {
            $user->jump = $user->jump + 1;
            $user->save();
        }
    }

    public static function getUserName($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        return $user["name"];
    }

    public static function getUserByID($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        return $user;
    }

    public static function getLevelByID($currentUser, $searchUserId)
    {
        $user_level_1 = User::where('referrals_id', '=', $currentUser->id)
            ->where('id', '=', $searchUserId)
            ->first();
        if ($user_level_1) {
            return 1;
        }

        $allUsersLevel1 = User::where('referrals_id', '=', $currentUser->id)->get();
        foreach ($allUsersLevel1 as $user_1) {
            $user_level_2 = User::where('referrals_id', '=', $user_1->id)
                ->where('id', '=', $searchUserId)
                ->first();
            if ($user_level_2) {
                return 2;
            }
        }

        foreach ($allUsersLevel1 as $user_1) {
            $allUsersLevel2 = User::where('referrals_id', '=', $user_1->id)
                ->where('id', '=', $searchUserId)
                ->get();
            foreach ($allUsersLevel2 as $user_2) {
                $user_level_3 = User::where('referrals_id', '=', $user_2->id)
                    ->where('id', '=', $searchUserId)
                    ->first();
                if ($user_level_3) {
                    return 3;
                }
            }
        }
        return 0;
    }
}
