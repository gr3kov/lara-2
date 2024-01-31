<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Voronkovich\SberbankAcquiring\Client;

class AgeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function checkAgePage()
    {

        \SEOMeta::setTitle('Онлайн аукцион Flame Auctoin в России купить и продать вещь на аукционе');
        \SEOMeta::setDescription('Онлайн аукцион Flame Auctoin оставить заявку на участие в аукционе России. Купить на аукционе вищь и выставить вещь на онлайн аукцион товаров в интернете в России.');
        \SEOMeta::setCanonical('https://imperialonline.ru');
        \SEOMeta::addKeyword(['онлайн аукцион', 'Flame Auctoin', 'россия', 'купить', 'продать', 'вещь', 'оставить', 'заявка', 'участие', 'выставить', 'товар', 'интернет']);

        return view('age18');
    }

    public function ageSet()
    {
        $age = \Cookie::make('age18', true, 2678400);
        return redirect('/')->withCookie($age);
    }

    public function ageExit()
    {
        return view('fail_age');
    }
}
