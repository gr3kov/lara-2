<?php

namespace App\Http\Controllers;

use App\Models\Token;

class TokenController extends Controller
{
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Токены
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list()
    {
        $token = Token::get();

        return view(
            'token.list',
            [
                'title' => 'Тарифы покупки FLAMES',
                'token' => $token,
            ]
        );
    }
}
