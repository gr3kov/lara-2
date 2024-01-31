<?php

use SleepingOwl\Admin\Navigation\Page;

return [
    [
        'title' => 'Главная',
        'icon' => 'fa fa-home',
        'url' => '/',
    ],
    [
        'title' => 'Пользователи',
        'icon' => 'fa fa-users',
        'pages' => [
            (new Page(\App\User::class))
                ->setPriority(100)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),

            (new Page(\App\Models\Role::class))
                ->setPriority(200)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
        ]
    ],
    [
        'title' => 'Аукцион',
        'icon' => 'fa fa-book',
        'pages' => [
            (new Page(\App\Models\AuctionCategory::class))
                ->setPriority(100)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\Auction::class))
                ->setPriority(100)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\AuctionAccordion::class))
                ->setPriority(110)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\Status::class))
                ->setPriority(200)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\Bid::class))
                ->setPriority(300)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\Shop::class))
                ->setPriority(400)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\AuctionEdit::class))
                ->setPriority(105)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\AuctionPayed::class))
                ->setPriority(106)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\AuctionDelivered::class))
                ->setPriority(107)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
        ]
    ],
    [
        'title' => 'Статистика',
        'icon' => 'fa fa-book',
        'pages' => [
            (new Page(\App\Models\UserStats::class))
                ->setPriority(100)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\BidStats::class))
                ->setPriority(200)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\Costs::class))
                ->setPriority(300)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\ActiveUsers::class))
                ->setPriority(400)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\BidDayStats::class))
                ->setPriority(500)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\UserBidStats::class))
                ->setPriority(600)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\BidBonus::class))
                ->setPriority(700)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\CookieToUrl::class))
                ->setPriority(800)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\UsersToUrl::class))
                ->setPriority(900)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin();
                }),
            (new Page(\App\Models\TargetRegister::class))
                ->setPriority(1000)
                ->setIcon('fa fa-circle-o')
                ->setAccessLogic(function (Page $page) {
                    return auth()->user()->isSuperAdmin() || auth()->user()->isManager();
                }),
        ]
    ],
    (new Page(\App\Models\PayOrder::class))
        ->setIcon('fa fa-circle')
        ->setAccessLogic(function (Page $page) {
            return auth()->user()->isSuperAdmin();
        }),
//    (new Page(\App\Models\SupportMessage::class))
//        ->setIcon('fa fa-circle')
//        ->setAccessLogic(function (Page $page) {
//            return auth()->user()->isSuperAdmin();
//        }),
//    (new Page(\App\Models\FeedBack::class))
//        ->setIcon('fa fa-circle')
//        ->setAccessLogic(function (Page $page) {
//            return auth()->user()->isSuperAdmin();
//        }),
    (new Page(\App\Models\RefCount::class))
        ->setIcon('fa fa-circle')
        ->setAccessLogic(function (Page $page) {
            return auth()->user()->isSuperAdmin();
        }),
    (new Page(\App\Models\Notification::class))
        ->setIcon('fa fa-circle')
        ->setAccessLogic(function (Page $page) {
            return auth()->user()->isSuperAdmin();
        }),
    (new Page(\App\Models\NotificationsNews::class))
        ->setIcon('fa fa-circle')
        ->setAccessLogic(function (Page $page) {
            return auth()->user()->isSuperAdmin();
        }),
//    (new Page(\App\Models\InstagramServer::class))
//        ->setIcon('fa fa-circle')
//        ->setAccessLogic(function (Page $page) {
//            return auth()->user()->isSuperAdmin();
//        }),
    (new Page(\App\Models\Docs::class))
        ->setIcon('fa fa-circle')
        ->setAccessLogic(function (Page $page) {
            return auth()->user()->isSuperAdmin();
        }),
    (new Page(\App\Models\SiteConfig::class))
        ->setIcon('fa fa-circle')
        ->setAccessLogic(function (Page $page) {
            return auth()->user()->isSuperAdmin();
        }),
    (new Page(\App\Models\UserBidAdd::class))
        ->setIcon('fa fa-circle')
        ->setAccessLogic(function (Page $page) {
            return auth()->user()->isSuperAdmin();
        }),
    (new Page(\App\Models\Autobid::class))
        ->setIcon('fa fa-circle')
        ->setAccessLogic(function (Page $page) {
            return auth()->user()->isSuperAdmin();
        }),
    (new Page(\App\Models\ProGuard::class))
        ->setIcon('fa fa-circle')
        ->setAccessLogic(function (Page $page) {
            return auth()->user()->isSuperAdmin();
        }),
    [
        'title' => 'Выход',
        'icon' => 'fa fa-sign-out',
        'url' => 'logout',
    ]
];
