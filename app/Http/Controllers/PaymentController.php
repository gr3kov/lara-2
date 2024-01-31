<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\PayOrder;
use App\Models\Token;
use App\Services\PayportPaymentGateway;
use App\Services\RukassaPaymentGateway;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $gateway;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['callback']]);
        //$this->middleware('activated');

        $checkCountry = true;

        if ($checkCountry) {
            $this->gateway = new PayportPaymentGateway();
        } else {
            $this->gateway = new RukassaPaymentGateway();
        }
    }

    /**
     * Экшен дёргается эквайрингом
     *
     * @param Request $request Приходит POST, все данные так же передаются в массиве POST
     * @return void
     */
    public function callback(Request $request)
    {
        $this->gateway->callback($request);
    }

    /**
     * Страница оплаты
     *
     * @param string $type Идентификатор типа (аукцион/токены)
     * @param string $id ID самого аукциона/токена
     * @return view/redirect
     */
    public function payment($type, $id)
    {
        $order = $this->prepare($type, $id);

        // Если при подготовке данных возникла ошибка - скажем об этом юзеру
        if (!$order->exists) {
            return view('payment.error');
        }

        $redirectUrl = $this->gateway->payment($order->user_id, $order->id, $order->price, true);

        if (!empty($redirectUrl)) {
            return redirect()->away($redirectUrl);
        }

        return view('payment.error');
    }

    /**
     * Определим, что будем продавать, создадим заказ на оплату в нашей системе
     *
     * @param string $type Идентификатор типа (аукцион/токены)
     * @param string $id ID самого аукциона/токена
     * @return object Объект заказа
     */
    private function prepare($type, $id)
    {
        $user = \Auth::user();

        $order = new PayOrder();

        // Определим, что будем продавать
        switch ($type) {
            case 'auction':
                $auction = Auction::find($id);
                if (!$auction) {
                    // Вернём пустой объект
                    return $order;
                }
                $goodName = $auction->name;
                $order->price = $auction->price;
                $order->auction_id = $auction->id;
                break;
            case 'token':
                $token = Token::find($id);
                if (!$token) {
                    // Вернём пустой объект
                    return $order;
                }
                $goodName = $token->value . ' токенов';
                $order->price = $token->price;
                $order->token_id = $token->id;
                break;
        }

        $description = 'Товар: ' . $goodName . ', кто купил: id ' . $user->id . ' email ' . $user->email;

        $order->user_id = $user->id;
        $order->status = PayOrder::STATUS_PREPARED;
        $order->description = $description;

        if (!$order->save()) {
            // Вернём пустой объект (да, тут тоже laravel будет считать модель как не exist)
            return $order;
        }

        return $order;
    }
}
