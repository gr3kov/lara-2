<?php

namespace App\Helpers;

class TextHelper
{
    /**
     * Метод форматирования телефона
     * Выводит телефон в заданном формате
     *
     * @param string $phone Номер телефона
     * @return string Номер телефона, приведённый к соответствующему стандарту
     */
    public static function phoneFormat($phone)
    {
        $phone = str_replace([' ', '-', '(', ')'], '', $phone);
        if (strlen($phone) == 11) {
            if ($phone[0] == 8) {
                $phone = ltrim($phone, '8');
                $phone = '+7' . $phone;
            } else if ($phone[0] == 7) {
                $phone = '+' . $phone;
            } else {
                return false;
            }
        } else if (strlen($phone) == 10) {
            $phone = '+7' . $phone;
        }

        if (strpos($phone, '+7') !== false) {
            return $phone;
        } else {
            return false;
        }
    }

    /**
     * Вывод численных результатов с учетом склонения слов
     *
     * @param integer $int
     * @param array   $expressions Например: ['ответ', 'ответа', 'ответов']
     */
    public static function declension($int, $expressions)
    {
        if (count($expressions) < 3) {
            $expressions[2] = $expressions[1];
        }

        settype($int, 'integer');
        $count = $int % 100;

        if ($count >= 5 && $count <= 20) {

            $result = $expressions['2'];
        } else {

            $count = $count % 10;

            if ($count == 1) {

                $result = $expressions['0'];
            } elseif ($count >= 2 && $count <= 4) {

                $result = $expressions['1'];
            } else {

                $result = $expressions['2'];
            }
        }

        return $result;
    }
}
