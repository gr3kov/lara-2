<?php

namespace App\Helpers;

class SidebarMenuHelper
{
    protected static $_instance;

    /**
     * @return SidebarMenuHelper
     */
    public static function instance()
    {
        if (!self::$_instance) {
            self::$_instance = new SidebarMenuHelper();
        }

        return self::$_instance;
    }

    public function getMenu()
    {
        $sidebarMenu = [
            'profile' => [
                'url' => route('profile'),
                'title' => 'Профиль',
                'imgPath' => '/img/icons/nav/profile.svg',
                'unread' => false,
                'counter' => false,
            ],
            'auctions' => [
                'url' => route('auction'),
                'title' => 'Аукционы',
                'imgPath' => '/img/icons/nav/auctions.svg',
                'unread' => false,
                'counter' => false,
            ],
            'tokens' => [
                'url' => route('tokens'),
                'title' => 'Токены',
                'imgPath' => '/img/icons/nav/tokens.svg',
                'unread' => false,
                'counter' => false,
            ],
            [
                'divider' => true,
            ],
            'myauctions' => [
                'url' => route('myAuction'),
                'title' => 'Мои аукционы',
                'imgPath' => '/img/icons/nav/myauctions.svg',
                'unread' => false,
                'counter' => false,
            ],
            'winners' => [
                'url' => route('winners'),
                'title' => 'Лента победителей',
                'imgPath' => '/img/icons/nav/winners.svg',
                'unread' => false,
                'counter' => false,
            ],

            [
                'divider' => true,
            ],
            'news' => [
                'url' => route('news'),
                'title' => 'Новости',
                'imgPath' => '/img/icons/nav/news.svg',
                'unread' => false,
                'counter' => false,
            ],
            'notifications' => [
                'url' => route('notifications'),
                'title' => 'Уведомления',
                'imgPath' => '/img/icons/nav/notifications.svg',
                'unread' => false,
                'counter' => false,
            ],
            'aboutus' => [
                'url' => route('about'),
                'title' => 'О нас',
                'imgPath' => '/img/icons/nav/aboutus.svg',
                'unread' => false,
                'counter' => false,
            ],
            [
                'divider' => true,
            ],
            'faq' => [
                'url' => route('faq'),
                'title' => 'Частые вопросы',
                'imgPath' => '/img/icons/nav/faq.svg',
                'unread' => false,
                'counter' => false,
            ],
            'support' => [
                'url' => '#',
                'title' => 'Техподдержка',
                'imgPath' => '/img/icons/nav/support.svg',
                'unread' => false,
                'counter' => false,
            ],
        ];

        if (auth()->check()) {
            $user = \Auth::user();

            if ($user->notification_count > 0) {
                $sidebarMenu['notifications']['unread'] = true;
                $sidebarMenu['notifications']['counter'] = $user->notification_count;
            }
        }

        return $sidebarMenu;
    }
}
