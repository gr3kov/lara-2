<?php

namespace App\Helpers;

class CheckListHelper
{
    protected static $_instance;

    /**
     * @return CheckListHelper
     */
    public static function instance()
    {
        if (!self::$_instance) {
            self::$_instance = new CheckListHelper();
        }

        return self::$_instance;
    }

    /**
     * Метод возвращает массив чеклиста с отмеченными позициями,
     * которые пользователь успешно выполнил
     *
     * @return array|array[]
     */
    public function getList()
    {
        $checkList = [
            1 => [
                'text' => 'Изучите информацию',
                'link' => [
                    'url' => route('about'),
                    'title' => 'о проекте',
                ],
                'image' => '/img/icons/checkboxes/ch1.svg',
            ],
            2 => [
                'text' => 'Пройдите верификацию аккаунта',
                'link' => [
                    'url' => route('settings'),
                    'title' => 'на странице профиля',
                ],
                'image' => '/img/icons/checkboxes/ch2.svg',
            ],
            3 => [
                'text' => 'Подпишитесь на официальный аккаунт в',
                'link' => [
                    'url' => 'https://instagram.com/flame.auction?igshid=MzMyNGUyNmU2YQ==',
                    'title' => 'Instagram',
                ],
                'image' => '/img/icons/checkboxes/ch3.svg',
            ],
            4 => [
                'text' => 'Подпишитесь на официальный',
                'link' => [
                    'url' => 'https://t.me/flameauction',
                    'title' => 'telegram канал',
                ],
                'image' => '/img/icons/checkboxes/ch4.svg',
            ],
            5 => [
                'text' => 'Ознакомьтесь с',
                'link' => [
                    'url' => route('winners'),
                    'title' => 'лентой победителей',
                ],
                'image' => '/img/icons/checkboxes/ch6.svg',
            ],

            6 => [
                'text' => 'Выберите и оплатите',
                'link' => [
                    'url' => route('tokens'),
                    'title' => 'пакет токенов',
                ],
                'additional' => 'для участия в аукционах',
                'image' => '/img/icons/checkboxes/ch8.svg',
            ],
            7 => [
                'text' => 'Выберите',
                'link' => [
                    'url' => route('auction'),
                    'title' => 'аукцион',
                ],
                'additional' => 'и примите в нем участие',
                'image' => '/img/icons/checkboxes/ch9.svg',
            ],
            8 => [
                'text' => 'Вступите в',
                'link' => [
                    'url' => 'https://t.me/flameplayerchat',
                    'title' => 'чат игроков',
                ],
                'image' => '/img/icons/checkboxes/ch10.svg',
            ],
            9 => [
                'text' => 'Ознакомьтесь с условиями',
                'link' => [
                    'url' => route('referral'),
                    'title' => 'партнерской программы',
                ],
                'image' => '/img/icons/checkboxes/ch11.svg',
            ],
            10 => [
                'text' => 'Вступите в',
                'link' => [
                    'url' => 'https://t.me/flamepartnerchat',
                    'title' => 'чат партнёров',
                ],
                'image' => '/img/icons/checkboxes/ch12.svg',
            ],
            11 => [
                'text' => 'Выведите',
                'link' => [
                    'url' => route('referral'),
                    'title' => 'партнёрские вознаграждения',
                ],
                'image' => '/img/icons/checkboxes/ch14.svg',
            ],
        ];

        // Отметим пункты чеклиста, которые юзер уже выполнил
        $user = \Auth::user();
        if ($user) {
            $userCheckList = json_decode($user->checklist);
            if (!empty($userCheckList)) {
                foreach ($userCheckList as $userCheckListItem) {
                    $checkList[$userCheckListItem]['checked'] = true;
                }
            }
        }

        return $checkList;
    }

    /**
     * Метод отмечает выполненные действия чеклиста
     *
     * @param $listIndex
     * @return void
     */
    public function mark($listIndex)
    {
        $user = \Auth::user();
        if ($user) {
            $checkList = json_decode($user->checklist);

            if ($this->check($listIndex)) {
                return;
            }

            if (empty($checkList)) {
                $checkList = [];
            }
            $checkList[] = $listIndex;
            $user->checklist = json_encode($checkList);
            // Начислить 50 ROTO
            // $user->bid = $user->bid + 50;
            $user->bid = 0;
            $user->save();

            // Создать уведомление для пользователя

        }
    }

    /**
     * Метод проверяет, прошёл ли юзер текуший шаг чеклиста
     * возвращает true если юзер уже прошёл шаг
     *
     * @param $listIndex
     * @return boolean
     */
    public function check($listIndex)
    {
        $user = \Auth::user();
        if ($user) {
            $checkList = json_decode($user->checklist);

            if (!empty($checkList) && in_array($listIndex, $checkList)) {
                return true;
            }
        }
        return false;
    }
}
