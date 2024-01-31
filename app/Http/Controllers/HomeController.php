<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Главная страница. Редирект на аукционы если пользователь авторизован или
     * редирект на лендинг если авторизации нет
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!auth()->check()) {
            //return redirect()->route('landing');
            return redirect()->route('login');
        }

        return redirect()->route('profile');
    }

    public function indexRedirect()
    {
        return redirect('/');
    }
}
