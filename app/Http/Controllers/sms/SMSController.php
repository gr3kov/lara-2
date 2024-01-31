<?php

namespace App\Http\Controllers\sms;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function index($sms, $phone)
    {
        $phpQueryPath = env('SMS_PATH');
        \File::requireOnce($phpQueryPath);

        $SMS4B = new CSms4bBase();

        $SMS4B->CSms4bBase(env('SMS_LOGIN'), env('SMS_PASSWORD'));
        $SMS4B->arBalance["Rest"]; // выводим текущий баланс

        $message = $sms;        // текст сообщения
        $to = $phone;    // номер, на который отправляем
        $destination = $SMS4B->parse_numbers($to);
        $sender = "imperial";

        $startUp = "";
        $dateActual = "";
        $period = "";
        //$result = $SMS4B->SendSmsPack($message, $destination, htmlspecialchars($sender), $startUp, $dateActual, $period);

        $result = $SMS4B->SendSMS($message, $to); // выполняем отправку
    }
}
