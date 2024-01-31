<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\Auction;
use App\Models\PayOrder;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RukassaPaymentGateway implements PaymentGatewayInterface
{
    private $merchantId;
    private $apiKey;
    private $apiUrl;
    private $apiVersion = 'api/v1/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (empty(env('PAYMENT_RUKASSA_MERCHANT_ID'))) {
            throw new \Exception('Empty merchant ID');
        }
        if (empty(env('PAYMENT_RUKASSA_API_KEY'))) {
            throw new \Exception('Empty API key');
        }
        if (empty(env('PAYMENT_RUKASSA_API_URL'))) {
            throw new \Exception('Empty API URL');
        }

        $this->merchantId = env('PAYMENT_RUKASSA_MERCHANT_ID');
        $this->apiKey = env('PAYMENT_RUKASSA_API_KEY');
        $this->apiUrl = env('PAYMENT_RUKASSA_API_URL');
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
        $text = '[RuKassa]' . $text;
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

        $this->log(json_encode($data), 'debug');

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
            'shop_id'	=> $this->merchantId,
            'token'		=> $this->apiKey,
            'order_id' 	=> $orderId,
            'amount' 	=> $price,
            //'data' 		=> json_encode($params),
        ];

        $method = 'create';

        $headers = [];

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
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
