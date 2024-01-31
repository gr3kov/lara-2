<?php

namespace App\Http\Controllers;

use App\Models\MoneyToken;
use App\Models\Operations;
use App\Models\PayOrder;
use App\Models\Auction;
use App\Models\Shop;
use Illuminate\Http\Request;
use \YandexMoney\API;
use \YandexMoney\ExternalPayment;
use App\User;
use Auth;
use App\Models\Notification;
use App\Models\SiteConfig;
use SoapClient;

class MoneyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function getToken()
    {
        $scope = "account-info payment-p2p operation-history operation-details";
        $moneyToken = MoneyToken::where('scope', '=', $scope)->first();
        if ($moneyToken == null) {
            return "false";
        }
        return $moneyToken->token;
    }

    public function index()
    {
        MoneyController::accountAuth();
    }

    public function saveToken($code)
    {
        $client_id = 'C377C2015AF33081813C41C154FEA7A6B5DDA5F883884B47CE1050DF3167EFC3';
        $redirect_uri = 'https://imperialonline.ru/proccess';
        $secret = '';
        $scope = "account-info payment-p2p operation-history operation-details incoming-transfers";
        $access_token_response = API::getAccessToken($client_id, $code, $redirect_uri, $client_secret = NULL);
        dd($access_token_response);
        $access_token = $access_token_response->access_token;
        $token = new MoneyToken();
        $token->token = $access_token;
        $token->scope = $scope;
        $token->save();
        return $token->token;
    }

    public function redirectFunction()
    {
        $code = $_GET["code"];
        dd($code);
        MoneyController::saveToken($code);
    }

    public function accountInfo()
    {
        $access_token = MoneyController::getToken();
        $api = new API($access_token);
        // get account info
        $acount_info = $api->accountInfo();
        return $acount_info;
    }

    public function accountHistory($start_record, $records)
    {
        $access_token = env('YANDEX_TOKEN_TR');
        var_dump($access_token);
        $api = new API($access_token);
        $operation_history = $api->operationHistory(array("start_record" => $start_record, "records" => $records));
        return $operation_history;
    }

    public function accountAuth()
    {
        $client_id = 'C377C2015AF33081813C41C154FEA7A6B5DDA5F883884B47CE1050DF3167EFC3';
        $redirect_uri = 'https://imperialonline.ru/proccess';
        $secret = NULL;
        $scope = ["account-info", "operation-history", "operation-details", "incoming-transfers", "payment-p2p", "money-source(\"wallet\")"];
        $fields = ["client_id" => $secret, "response_type" => "code", "redirect_uri" => $redirect_uri, "scope" => $scope];
        $url = "https://money.yandex.ru/oauth/authorize";
        $auth_url = API::buildObtainTokenUrl($client_id, $redirect_uri, $scope);
        return redirect($auth_url);

        /*
     *  account-info	Получение информации о состоянии счета, см. метод account-info.
        operation-history	Просмотр истории операций, см. метод operation-history.
        operation-details	Просмотр деталей операции, см. метод operation-details.
        incoming-transfers	Прием/отмена входящих переводов с кодом протекции и до востребования.
        payment	Возможность осуществлять платежи в конкретный магазин или переводить средства на конкретный счет Пользователя, см. методы request-payment и process-payment.
        payment-shop	Возможность осуществлять платежи во все доступные для API магазины, см. методы request-payment и process-payment.
        payment-p2p	Возможность переводить средства на любые счета, номера телефонов, email-адреса других пользователей, см. методы request-payment и process-payment
        money-source
        Доступные методы проведения платежа, см. методы request-payment и process-payment. Подробнее см. Право money-source.
         * */
    }

    public function getOperationDetails($operation_id)
    {
        $api = new API(env('YANDEX_TOKEN_TR'));
        $result = $api->operationDetails($operation_id);
        return $result;
    }

    public function moneyCallback(Request $request)
    {
        dd(MoneyController::accountHistory(100));
    }

    public function amountWithoutCommission($commissionRate, $amount)
    {
        $result = $amount / (1 - $commissionRate);
        return $result;
    }

    public function determineYandexAccount($sum)
    {
        return 0;
    }

    public function buyBid($id, Request $request)
    {
        $user = \Auth::user();
        if ($user->is_ban == 1) { //Забанен нельзя платить
            return redirect('/');
        }
        if ($request->server('HTTP_REFERER') !== 'https://imperialonline.ru/pay'
            && $request->server('HTTP_REFERER') !== 'https://auction.imperialonline.ru/pay'
            && $request->server('HTTP_REFERER') !== 'https://test.imperialonline.ru/pay') {
            return redirect('/'); //Если вернулся с яндекса то на главную
        }

        $shopElement = Shop::find($id);
        $data['error'] = 'Ошибка оплаты';
        if ($shopElement) {
            $description = 'Товар: ' . $shopElement->name . ', кто купил: id ' . $user->id . ' email ' . $user->email . ' uniteller';
            $orderID = mt_rand(5000, 945000000);
            $newOrder = new PayOrder();
            $newOrder->order = $orderID;
            $newOrder->sber_order = $orderID;
            $newOrder->user_id = $user->id;
            $newOrder->price = $shopElement->price;
            $newOrder->shop_id = $shopElement->id;
            $newOrder->status = 'create';
            $newOrder->sber_message = '';
            $newOrder->success = 0;
            $newOrder->add_bid = 0;
            $newOrder->description = $description;
            $newOrder->save();

            $data = $this->getFormData($shopElement, $user, $orderID);

            return view('uniteller-form', ['data' => $data]);
        }

    }

    public function buyAuction($id, Request $request)
    {
        $user = \Auth::user();
        if ($user->is_ban == 1) { //Забанен нельзя платить
            return redirect('/');
        }
        if ($request->server('HTTP_REFERER') !== 'https://imperialonline.ru/my-auction'
            && $request->server('HTTP_REFERER') !== 'https://auction.imperialonline.ru/my-auction'
            && $request->server('HTTP_REFERER') !== 'https://test.imperialonline.ru/my-auction'

            && $request->server('HTTP_REFERER') !== 'https://imperialonline.ru/'
            && $request->server('HTTP_REFERER') !== 'https://auction.imperialonline.ru/'
            && $request->server('HTTP_REFERER') !== 'https://test.imperialonline.ru/') {
            return redirect('/'); //Если вернулся с яндекса то на главную
        }
        $auctionElement = Auction::find($id);
        $data['error'] = 'Ошибка оплаты';
        if ($auctionElement) {
            $description = 'Товар: ' . $auctionElement->name . ', кто купил: id ' . $user->id . ' email ' . $user->email . ' uniteller';
            $orderID = mt_rand(5000, 945000000);
            $newOrder = new PayOrder();
            $newOrder->order = $orderID;
            $newOrder->sber_order = $orderID;
            $newOrder->user_id = $user->id;
            $newOrder->price = $auctionElement->price;
            $newOrder->auction_id = $auctionElement->id;
            $newOrder->status = 'create';
            $newOrder->sber_message = '';
            $newOrder->success = 0;
            $newOrder->add_bid = 0;
            $newOrder->description = $description;
            $newOrder->save();

            $data = $this->getFormData($auctionElement, $user, $orderID);
            return view('uniteller-form', ['data' => $data]);
        }

    }

    private function getSignature($data)
    {
        $password = env('UNITELLER_PASSWORD');
        $meanType = '';
        $eMoneyType = '';
        $customerIDP = '';
        $cardIDP = '';
        $idata = '';
        $ptCode = '';

        $signature = strtoupper(md5(md5($data['shop_idp']) . '&' .
            md5($data['order']) . '&' . md5($data['sum']) . '&' .
            md5($meanType) . '&' . md5($eMoneyType) . '&' .
            md5($data['lifetime']) . '&' . md5($customerIDP) . '&' .
            md5($cardIDP) . '&' . md5($idata) . '&' .
            md5($ptCode) . '&' . md5($password)));

        return $signature;
    }

    private function getFormData($element, $user, $order)
    {
        $data['user_id'] = $user->id;
        $data['email'] = $user->email;
        $data['sum'] = $element->price;
        $data['order'] = $order;
        $data['shop_idp'] = env('SHOP_IDP');
        $data['url_return_ok'] = 'https://imperialonline.ru/pay/ok';
        $data['url_return_no'] = 'https://imperialonline.ru/finish';
        $data['lifetime'] = 300;
        $data['comment'] = $element->name;
        $data['signature'] = $this->getSignature($data);
        return $data;
    }

    public function payOk(Request $request)
    {
        if ($request->Order_ID) {
            $order = PayOrder::where('success', 0)->where('order', $request->Order_ID)->first();
            if ($order) {
                $details = $this->payProcess($order);
                if ($details) {
                    $this->payCredit($details, $order);
                }
            }
        }
        return redirect('/');
    }

    public function payProcess($orderEl)
    {
        ini_set('soap.wsdl_cache_enabled', '0');
        ini_set('soap.wsdl_cache_ttl', '0');
        $client = new SoapClient("https://wpay.uniteller.ru/results/wsdl/", array(
                'trace' => 0,
                'exceptions' => 1,)
        );

        // Настройки заказа
        $Order_ID = (string)$orderEl->order;
        // Настройки магазина
        $Shop_ID = env('SHOP_IDP');
        $login = env('UNITELLER_LOGIN');
        $password = env('UNITELLER_PASSWORD');
        $result = $client->GetPaymentsResult($Shop_ID
            , $login
            , $password
            , $Order_ID
            , $success = 1
            , $startmin = null
            , $starthour = null
            , $startday = null
            , $startmonth = null
            , $startyear = null
            , $endmin = null
            , $endhour = null
            , $endday = null
            , $endmonth = null
            , $endyear = null
            , $meantype = null
            , $emoneytype = null
            , $english = null
            , $startminofchange = null
            , $starthourofchange = null
            , $startdayofchange = null
            , $startmonthofchange = null
            , $startyearofchange = null
            , $endminofchange = null
            , $endhourofchange = null
            , $enddayofchange = null
            , $endmonthofchange = null
            , $endyearofchange = null
        );
        // проверяем что запись об этой транзакции есть и сумма транзакции та, // которая была указана на странице "корзина"
        if (count($result) == 1) {
            $resultObj = $result[0];
            return $resultObj;
        } else {
            return false;
        }
    }

    public function payCredit($details, $order)
    {
        if ($details->status == 'Paid' || $details->status == 'Authorized') { //меньше 100 для тестирования малых сумм
            $user = User::where('id', '=', $order->user_id)->first();
            if ($user != null) {
                $shopElement = Shop::find($order->shop_id);
                $auctionElement = Auction::find($order->auction_id);
                if ($shopElement && $order->add_bid == 0) {
                    $doubleBid = SiteConfig::where('code', 'double-pay-bid')->where('value', 'on')->first();
                    $newBid = $shopElement->count;
                    $messageConfig = '';

                    if (isset($doubleBid)) {
                        $newBid = $shopElement->count * 2;
                        $messageConfig = 'Бонус удвоения';
                    }
                    $user->bid = $user->bid + $newBid;
                    $order->success = 1;
                    $order->add_bid = 1;
                    $order->save();
                    $user->save();

                    $notification = new Notification();
                    $notification->name = 'Покупка ставок ' . $shopElement->name . ' ' . $user->id . ' uniteller. ' . $messageConfig;
                    $notification->item_id = $shopElement->id;
                    $notification->user_id = $user->id;
                    $notification->type = 'pay';
                    $notification->item_type = 'shop';
                    $notification->already_send = 0;
                    $notification->save();
                } else if ($auctionElement && $order->add_bid == 0) {
                    $order->success = 1;
                    $order->add_bid = 1;
                    $order->save();

                    $notification = new Notification();
                    $notification->name = 'Покупка лота ' . $auctionElement->name . ' ' . $user->id . ' uniteller. ';
                    $notification->item_id = $auctionElement->id;
                    $notification->user_id = $user->id;
                    $notification->type = 'pay';
                    $notification->item_type = 'auction';
                    $notification->already_send = 0;
                    $notification->save();

                    if ($auctionElement->category == 'bid' && $auctionElement->bid) {
                        $bid = $auctionElement->bid > 0 ? $auctionElement->bid : 0;
                        $user->bid = $user->bid + $bid;
                        $user->save();

                        $notification = new Notification();
                        $notification->name = 'Автоматическое начисление ставок ' . $auctionElement->name . ' ' . $user->id . ' количество ' . $bid;
                        $notification->item_id = $auctionElement->id;
                        $notification->user_id = $user->id;
                        $notification->type = 'add-bid';
                        $notification->item_type = 'auction';
                        $notification->already_send = 0;
                        $notification->save();
                    }

                    $auctionElement->timestamps = false;
                    $auctionElement->payed = 1;
                    $auctionElement->leader_id = $user->id;
                    $auctionElement->save();

                    if ($auctionElement->category !== 'bid') { //уведомление чтобы делать доставку
                        $bot = new TelegramController();
                        $bot->sendDeliveryItem($notification->id);
                    }
                }
            }
        }
    }
}
