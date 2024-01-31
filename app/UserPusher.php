<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class UserPusher extends User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        //'name',
        'email',
        'role_id',
        'confirmation_code',
        'confirmed',
        'referrals_id',
        'news_subs',
        'is_send_conf',
        'active',
        'agreement',
        'personal_data',
        'bid',
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

    public function isSuperAdmin()
    {
        $admin = User::where('id', '=', $this->id)
            ->where('role_id', '=', 1)
            ->first();
        if ($admin) {
            return true;
        } else {
            return false;
        }
    }

    public function isManager()
    {
        $operator = User::where('id', '=', $this->id)
            ->where('role_id', '=', 2)
            ->first();
        if ($operator) {
            return true;
        } else {
            return false;
        }
    }
}
