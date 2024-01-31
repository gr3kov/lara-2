<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CookieToUrl;
use App\Models\UsersToUrl;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validateRegister(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8',
                'agreement' => 'required',
                'phone' => 'required|min:11|numeric',
            ],
            [
                'email.required' => 'Email обязателен к заполнению',
                'email.unique' => 'Такой Email уже используется',
                'name.required' => 'Никнейм обязателен к заполнению',
                'password.required' => 'Пароль обязателен к заполнению',
                'password.confirmed' => 'Пароли не совпадают',
                'password.min' => 'Пароль минимум 8 символов',
                'agreement.required' => 'Согласие на условие платформы обязательно',
                'phone.required' => 'Телефон обязателен к заполнению',
                'phone.min' => 'Нужно ввести мобильный номер телефона',
                'phone.min:11' => 'Нужно ввести мобильный номер телефона',
                'phone.numeric' => 'Для ввода номера телефона используйте только цифры',
            ]
        );
    }

    public function registerAction(Request $request)
    {
        $message = '';
        if ($request->isMethod('post')) {
            $email = $request->input('email');
            $phone = $request->input('phone');
            $password = $request->input('password');

            $referralsCode = \Cookie::get('ref');
            $referralsId = $referralsCode ? User::where('ref_code', $referralsCode)->first()['id'] : null;
            $this->validateRegister($request);
            $wasIp = $request->ip() . ':' . $request->server('HTTP_USER_AGENT');
            $haveUserInIp = User::where('reg_ip', $wasIp)->first();
            $validator = new EmailValidator();
            $multipleValidations = new MultipleValidationWithAnd([
                new RFCValidation(),
                new DNSCheckValidation()
            ]);

            if (!$validator->isValid($email, $multipleValidations)) {
                $message = 'Не верный формат email';
            }

            if ($haveUserInIp && !config('app.debug')) {
                $message = 'У вас уже есть аккаунт. При возникновении проблем, обратитесь в службу поддержки';
            }

            if (strpos($wasIp, 'Windows NT 10.0') !== false) {
                $message = 'Произошла ошибка, обратитесь в поддержку';
            }

            if (empty($message)) {

                User::create([
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role_id' => 3, //user
                    'agreement' => isset($data['agreement']) ? true : false,
                    'photo' => null,
                    'referrals_id' => isset($referralsId) ? $referralsId : 0,
                    'reg_ip' => $wasIp,
                    'delivery_phone' => $phone,
                ]);

                $loginController = new LoginController();
                $loginResult = $loginController->login($email, $password);
                if (!empty($loginResult['message'])) {
                    $message = $loginResult['message'];
                }
                if (!empty($loginResult['redirect'])) {
                    return $loginResult['redirect'];
                }

                $cookie = \Cookie::get('visited');
                if ($cookie) {
                    $user = User::where('email', $email)->first();
                    $cookieToUrl = CookieToUrl::where('cookie', $cookie)->first();
                    if ($cookieToUrl) {
                        if ($cookieToUrl->target) {
                            $usersToUrl = UsersToUrl::where('target', $cookieToUrl->target)->
                            where('user_id', $user->id)->where('url', $cookieToUrl->url)->first();
                            if (!$usersToUrl) {
                                $usersToUrl = new UsersToUrl();
                                $usersToUrl->target = $cookieToUrl->target;
                                $usersToUrl->source = $cookieToUrl->source;
                                $usersToUrl->device = $cookieToUrl->device;
                                $usersToUrl->url = $cookieToUrl->url;
                                $usersToUrl->host = $cookieToUrl->host;
                                $usersToUrl->user_id = $user->id;
                                $usersToUrl->save();
                            }
                        }
                    }
                }

                if (empty($message)) {
                    return redirect()->route('profile');
                }
            }
        }
        return view(
            'pages.auth',
            [
                'message' => $message,
            ]
        );
    }
}
