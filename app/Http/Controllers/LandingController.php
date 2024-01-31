<?php

namespace App\Http\Controllers;

use App\Models\Page;

class LandingController extends Controller
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
     * Страница лендинга
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view(
            'landing.index',
            [
                'faq' => Page::$_faqArray,
            ]
        );
    }
}
