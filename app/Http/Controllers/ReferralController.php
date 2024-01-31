<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Voronkovich\SberbankAcquiring\Client;

class ReferralController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function registerReferral($code)
    {
        $name = 'ref';
        $value = $code;
        $minutes = '11600';
        \Cookie::queue($name, $value, $minutes);
        return redirect(route('register'));
    }
}
