<?php
/**
 * Send confirmation SMS by Bytehand service
 */

namespace App\Http\Controllers;

class SmsController extends Controller
{
    private $apiUrl;
    private $apiKey;

    /**
     * API constructor
     *
     * @throws \Exception
     */
    function __construct()
    {
        if (empty(env('SMS_API'))) {
            throw new \Exception('Empty API url');
        }
        if (empty(env('SMS_APIKEY'))) {
            throw new \Exception('Empty API key');
        }

        $this->apiUrl = env('SMS_API');
        $this->apiKey = env('SMS_APIKEY');
    }

    public function send()
    {
        $this->sendSms('+79049755463', 'привет');
    }

    /**
     * Метод отправки текста СМС в API
     * См документацию https://www.bytehand.com/ru/developers/v2/methods/id/sendSmsUsingPOST
     *
     * @param string $phone Номер телефона
     * @param string $text Отправляемое содержимое
     * @return string Ответ от API
     */
    public function sendSms($phone, $text)
    {
        $data = [
            'sender'   => 'Flame auction',
            'receiver' => $phone,
            'text'     => $text,
        ];

        $headers = [
            'Content-Type: application/json',
            'X-Service-Key: ' . $this->apiKey,
        ];

        $requestResult = $this->request('sms/messages', $headers, $data);

        throw new \Exception($requestResult);
        if ($this->debug) {
            Logging::storeLog(
                'openAi',
                'Переданные данные: ' . json_encode($data, JSON_PRETTY_PRINT)
                . PHP_EOL . 'Заголовки: ' . json_encode($headers, JSON_PRETTY_PRINT)
                . PHP_EOL . 'Ответ: ' . $requestResult
            );
        }

        $requestResultObj = json_decode($requestResult);

        // Если вдруг пришла ошибка
        if (property_exists($requestResultObj, 'error')) {
            Logging::storeLog(
                'openAi',
                'Переданные данные: ' . json_encode($data, JSON_PRETTY_PRINT)
                . PHP_EOL . 'Ответ: ' . $requestResult,
                2
            );
            return '';
        }

        // Если пришли актуальные данные
        if (property_exists($requestResultObj, 'choices') && is_array($requestResultObj->choices)
            && isset($requestResultObj->choices[0]) && property_exists($requestResultObj->choices[0], 'message')
            && property_exists($requestResultObj->choices[0]->message, 'content')
        ) {
            return $requestResultObj->choices[0]->message->content;
        }

        return '';
    }

    /**
     * Общий метод запросов к API
     */
    public function request($method, $headers, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode != 200) {
            var_dump($this->apiUrl . $method);
            var_dump($headers);
            var_dump(json_encode($data));
            var_dump($result);
            throw new \Exception('Всё плохо');
        }

        return $result;
    }
}
