<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    public function __construct()
    {
        $this->middleware('guest')->except('logoutAction');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'email.required' => 'Username or email is required',
                'password.required' => 'Password is required',
            ]
        );
    }

    public function loginAction(Request $request)
    {
        $message = '';
        if ($request->isMethod('post')) {
            $message = 'Неверный логин или пароль';
            $email = $request->input('email');
            $password = $request->input('password');
            $loginResult = $this->login($email, $password);
            if (!empty($loginResult['message'])) {
                $message = $loginResult['message'];
            }
            if (!empty($loginResult['redirect'])) {
                return $loginResult['redirect'];
            }
        }
        return view(
            'pages.auth',
            [
                'message' => $message,
            ]
        );
    }

    public function logoutAction()
    {
        Auth::logout();
        return redirect('https://project8209146.tilda.ws/');
    }

    /**
     * Метод авторизации. Используется при логине и при регистрации
     *
     * @param $email
     * @param $password
     * @return array
     */
    public function login($email, $password)
    {
        $return = [
            'message' => '',
            'redirect' => '',
        ];
        $userIsBan = User::where('email', $email)->where('is_ban', 1)->first();
        if ($userIsBan) {
            $return['message'] = 'Аккаунт заблокирован. Обратитесь в поддержку.';
        } elseif (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = User::where('email', $email)->first();
            if ($user->isManager()) {
                $return['redirect'] = redirect('/admin/target_registers');
            } else {
                $return['redirect'] = redirect()->route('home');
            }
        }

        return $return;
    }
}
