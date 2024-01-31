<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BidBonus;
use App\Models\CookieToUrl;
use App\Models\SiteConfig;
use App\Models\UsersToUrl;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ActivateController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index($token = null)
    {
        $redirectUrl = route('activate-info');

        $confirmationCode = User::where('confirmation_code', '=', $token)
            ->first();

        if ($confirmationCode) {
            $confirmationCode->confirmed = 1;
            $confirmationCode->save();

            \Auth::login($confirmationCode);

            $configBonus = SiteConfig::where('code', 'reg-bonus-10')->where('value', 'on')->first();
            if (isset($configBonus)) {
                $this->addBonus($confirmationCode);
            }

            $redirectUrl = route('profile');
        }

        return redirect($redirectUrl);
    }

    public function addBonus($user)
    {
        $currentBonus = BidBonus::where('user_id', $user['id'])
            ->where('code', 'register')->first();
        //бонус по регистрации
        if (!$currentBonus) {
            $registerBonus = 10;
            $bonus = new BidBonus();
            $bonus->user_id = $user['id'];
            $bonus->code = 'register';
            $bonus->bid_count = $registerBonus;
            $bonus->save();

            $user->bid = $user['bid'] + $registerBonus;
            $user->save();
        }
    }
}
