<?php

namespace App\Http\Controllers;

use App\Models\NotificationsNews;
use App\Models\UsersNotification;
use App\Models\Notification;
use App\Models\Auction;
use Artesaos\SEOTools\Facades\SEOMeta;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Страница уведомлений
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function notifications()
    {
        SEOMeta::setTitle('Уведомления');
        SEOMeta::setDescription('Уведомления');
        SEOMeta::setCanonical(route('notifications'));
        SEOMeta::addKeyword('уведомления');

        $notifications['new'] = [];

        //$notifications=[];

        $user = \Auth::user();
        if ($user) {
            $notifications['new'] = $this->getListNotifications($user->id);

            // Пометим все нотификации как прочитанные
            $user->notification_count = 0;
            $user->save();
        }

        return view(
            'profile.notifications',
            [
                'title' => 'Уведомления',
                'notifications' => $notifications,
            ]
        );
    }

    /**
     * Метод получения списка уведомлений юзера через AJAX
     *
     * @return false|string
     */
    public function getNotification()
    {
        $result = [
            'notifications' => [],
            'notificationShow' => 0,
            'notificationCount' => 0,
        ];

        $user = \Auth::user();
        if ($user) {
            $result['notifications'] = $this->getListNotifications($user->id);
            $result['notificationShow'] = $user->show_notifications;
            $result['notificationCount'] = $user->notification_count;
        }

        return json_encode($result);
    }

    public function readNotification()
    {
        $user = \Auth::user();
        if ($user) {
            $count = $user->notification_count;
            if ($count > 0) {
                $user->notification_count = $count - 1;
                $user->save();
            }
        }
    }

    public function notificationToggle()
    {
        $user = \Auth::user();
        if ($user) {
            $user->show_notifications = $user->show_notifications == 1 ? 0 : 1;
            $user->save();
        }
    }

    /**
     * Метод формирует список уведомлений и возвращает его
     *
     * @param $userId string Идентификатор авторизованного пользователя
     *
     * @return array Массив уведомлений пользователя
     */
    private function getListNotifications($userId)
    {
        $notifications = [];
        $usersNotification = UsersNotification::where('user_id', $userId)->get();
        if ($usersNotification) {
            foreach ($usersNotification as $usersNotificationItem) {
                $notification = Notification::where(
                    'id', $usersNotificationItem->notification_id
                )->first();
                if($notification != null) {
                    $auction = Auction::where('id', $notification->item_id)->first();

                    if (!$auction) {
                        continue;
                    }
                    $array = [
                        'title' => $notification->title,
                        'date' => strtotime($notification->created_at),
                        'text' => $notification->name,
                        'unread' => $usersNotificationItem->is_show,
                        'auction' => [
                            'id' => $auction->id,
                            'url' => route('item', ['id' => $auction->id]),
                            'image' => $auction->preview_image,
                            'title' => $auction->name,
                        ],
                    ];
                    $notifications[] = $array;
                }
            }
        }


        if(is_array($notifications)) {
            usort(
                $notifications, function ($a, $b) {
                return $a['date'] - $b['date'];
            }
            );
        }

        return array_reverse($notifications);
    }
}
