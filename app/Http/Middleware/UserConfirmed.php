<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class UserConfirmed
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->auth->getUser();
        $confirmed = $user->confirmed;
        $is_send_conf = $user->is_send_conf;
        $message = 'Пожалуйста, активируйте аккаунт. Код активации находится внутри письма.';

        if (isset($confirmed) && $confirmed == "0" && $is_send_conf == "0") {
            // If the user has not had an activation token set
            $confirmation_code = $user->confirmation_code;
            if (empty($confirmation_code) || $confirmation_code == "0") {
                // generate a confirmation code
                $key = \Config::get('app.key');
                $confirmation_code = hash_hmac('sha256', \Str::random(40), $key);
                $user->confirmation_code = $confirmation_code;
                $user->save();
            }
            $actionUrl = route('activate', ['token' => $confirmation_code]);

            \Mail::send(['emails.activate', 'emails.activate_text'], ['actionUrl' => $actionUrl, 'name' => $user->name], function ($message) use ($user) {
                $message->to($user->getEmailForPasswordReset(), $user->name)
                    ->subject('Активация аккаунта');
            });

            $user->is_send_conf = true;
            $user->save();

            return redirect(route('activate-info'))->with(['message' => $message,
                'alreadySend' => 'yes']);
        } else if ($is_send_conf == "1" && $confirmed == "0") {
            return redirect(route('activate-info'))->with(['message' => $message,
                'alreadySend' => 'yes']);
        }
        return $next($request);
    }
}
