<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\Auction;
use App\Models\PayOrder;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayportPaymentGateway implements PaymentGatewayInterface
{
    private $merchantId;
    private $apiKey;
    private $apiUrl;
    private $apiVersion = 'api/v5/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (empty(env('PAYMENT_PAYPORT_MERCHANT_ID'))) {
            throw new \Exception('Empty merchant ID');
        }
        if (empty(env('PAYMENT_PAYPORT_API_KEY'))) {
            throw new \Exception('Empty API key');
        }
        if (empty(env('PAYMENT_PAYPORT_API_URL'))) {
            throw new \Exception('Empty API URL');
        }

        $this->merchantId = env('PAYMENT_PAYPORT_MERCHANT_ID');
        $this->apiKey = env('PAYMENT_PAYPORT_API_KEY');
        $this->apiUrl = env('PAYMENT_PAYPORT_API_URL');
    }

    /**
     * Отладка в файл
     *
     * @param string $text Текст сообщения
     * @param string $type Тип сообщения
     * @return void
     */
    private function log($text, $type)
    {
        if (!env('APP_DEBUG')) {
            return;
        }
        $text = '[PayPort]' . $text;
        Log::{$type}($text);
    }

    /**
     * Экшен дёргается эквайрингом
     *
     * @param Request $request Приходит POST, все данные так же передаются в массиве POST
     * @return void
     */
    public function callback(Request $request)
    {
        $data = $request->post();

        // Формат ответа
        //{"invoice_id":"70751","merchant_id":"632","order_id":"15771","amount":"20.439673","amount_currency":"1999","currency":"RUB","order_desc":"\u041f\u043e\u043a\u0443\u043f\u043a\u0430
        //Royal-Auction","merchant_amount":"19.213293","status":"1","account_info":"453958******2309","fiat_currency":"RUB","fiat_amount":"1999","payment_system_type":"card_number","signature
        //":"71211f23dd86407f58da9205411a2fc70a49ee5c"}
        // Не успех
        //{"invoice_id":"70761","merchant_id":"632","order_id":"15782","amount":"15.337423","amount_currency":"1500","currency":"RUB","order_desc":"\u041f\u043e\u043a\u0443\u043f\u043a\u0430
        //Royal-Auction","merchant_amount":"14.417178","status":"-1","account_info":"453958******2309","fiat_currency":"RUB","fiat_amount":"1500","cancellation_reason":"NO_PAYMENT_RECEIVED","
        //payment_system_type":"card_number","signature":"30c748c92249442dc6dcb4ea4fb47927af60131a"}
        // Перерасчёт
        //{"invoice_id":"71388","merchant_id":"632","order_id":"15793","amount":"20.439673","amount_currency":"1999","currency":"RUB","order_desc":"\u041f\u043e\u043a\u0
        //443\u043f\u043a\u0430 Royal-Auction","merchant_amount":"19.213293","status":"-1","account_info":"453958******2309","fiat_currency":"RUB","fiat_amount":"1999","cancellation_reason":"
        //RECALCULATION","payment_system_type":"card_number","signature":"c98a184d69130701d266bb704211c8b08497355f"}
        //{"invoice_id":"71388","merchant_id":"632","order_id":"15793","amount":"10.214724","amount_currency":"999","currency":"RUB","order_desc":"\u041f\u043e\u043a\u04
        //43\u043f\u043a\u0430 Royal-Auction","merchant_amount":"9.601841","status":"1","account_info":"453958******2309","fiat_currency":"RUB","fiat_amount":"999","payment_system_type":"card
        //_number","signature":"9636d3d3edc9f7a5f40521e4688df6fdb25d549e"}

        $this->log(json_encode($data), 'debug');

        // Если нет идентификатора заказа в инвойсе - выходим
        if (!isset($data['order_id'])) {
            $this->log('В инвойсе нет ID заказа', 'critical');
            return;
        }

        $order = PayOrder::find($data['order_id']);

        if (isset($order)) {

            $this->log('Нашли модель', 'debug');

            // Если заказ уже оплачен - выходим
            //if (($order->status == PayOrder::STATUS_APPROVED) && (($order->paid != 0) || ($order->paid == $data['amount_currency']))) {
            if ($order->status == PayOrder::STATUS_APPROVED) {
                $this->log('Уже оплачен', 'info');
                return;
            }

            $user = User::find($order->user_id);
            if (!$user) {
                $this->log('Пользователь не найден. User ID:' . $order->user_id, 'critical');
                return;
            }

            // Инвойс успешно оплачен
            if ($data['status'] == 1) {

                $order->status = PayOrder::STATUS_APPROVED;
                $order->response = json_encode($data);

                if ($order->token_id !== null) {

                    $this->log('Зашли в сохранение токенов', 'debug');

                    $token = Token::find($order->token_id);

                    // Начислим юзеру ROTO
                    if ($token) {
                        $user->bid = $user->bid + $token->value;

                        $this->log('Подготовка к сохранению модели юзера', 'debug');

                        if (!$user->save()) {
                            $this->log('Не удалось сохранить модель юзера', 'critical');
                        }
                    }
                }

                if ($order->auction_id !== null) {

                    $this->log('Зашли в сохранение аукциона', 'debug');

                    $auction = Auction::find($order->auction_id);

                    // Поставим флаг оплачено
                    if ($auction) {
                        $auction->payed = 1;

                        $this->log('Подготовка к сохранению модели аукциона', 'debug');

                        if (!$auction->save()) {
                            $this->log('Не удалось сохранить модель аукциона', 'critical');
                        }
                    }
                }
            }

            // Ошибка оплаты инвойса
            if ($data['status'] == -1) {
                $this->log('Ошибка оплаты инвойса', 'info');

                if (in_array($order->status, [PayOrder::STATUS_FAILED, PayOrder::STATUS_APPROVED])) {
                    return;
                }
                $order->status = PayOrder::STATUS_FAILED;
                $order->response = $data['cancellation_reason'];
            }
            if ($data['status'] == 3) {
                $this->log('Инвойс ' . $data['invoice_id'] . ' в работе', 'info');

                if ($order->status == PayOrder::STATUS_PREPARED) {
                    $order->status = PayOrder::STATUS_IN_PROGRESS;
                }
            }

            if (!$order->save()) {
                $this->log('Не удалось сохранить модель заказа', 'critical');
            }
        }
    }

    /**
     * Метод получения урла, для перенаправления юзера на страницу оплаты
     *
     * @param integer $userId Идентификатор пользователя
     * @param integer $orderId Идентификатор заказа
     * @param integer $price Стоимость заказа
     * @param boolean $noReceipt Флаг для платежа без чека
     * @return string Урл для редиректа
     */
    public function payment($userId, $orderId, $price, $noReceipt)
    {
        $data = [
            'merchant_id' => $this->merchantId,
            'amount' => $price,
            'currency' => 'RUB',
            'order_id' => $orderId,
            'order_desc' => 'Покупка Royal-Auction',
            'response_url' => route('home'),
            'server_url' => route('payment-callback'),
            'customer_id' => strval($userId),
            'payment_attributes' => [
                'client_name' => 'User ' . $userId,
                'client_email' => $userId . '@royal-auction.com'
            ],
        ];

        $method = 'invoice/get';
        if ($noReceipt) {
            $method = 'invoice/get_noreceipt';
        }

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey,
        ];

        $requestResult = $this->request($method, $headers, $data);

        $this->log('Параметра запроса: ' . json_encode($data) . PHP_EOL . 'Ответ: ' . $requestResult, 'debug');

        $requestResultObj = json_decode($requestResult);

        if (property_exists($requestResultObj, 'url')) {
            return $requestResultObj->url;
        }

        return '';
    }

    /**
     * Общий метод запросов к API
     */
    private function request($method, $headers, $data)
    {
        $url = $this->apiUrl . $this->apiVersion . $method;

        $this->log('Выполняем запрос на URL: ' . $url, 'debug');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
