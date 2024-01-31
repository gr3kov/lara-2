<?php

namespace App\Helpers;

use App\Models\Auction;
use App\Models\AuctionCategory;
use App\Models\Bid;
use App\Models\ProGuard;
use App\User;
use Carbon\Carbon;

class AuctionHelper
{
    public static function sendMessageToGuard($auction, $currentUser)
    {
        $auctionTimeLeft = $auction->time_left;
        $auctionId = $auction->id;
        $auctionTimeLastInterval = $auction->time_last_interval;

        $auctionGuard = ProGuard::where('auction_id', $auction->id)->where('guard', true)->first();
        $strUsers = [];
        foreach ($auctionGuard->users as $user) {
            if ($user->id == $currentUser) {
                continue;
            } else {
                array_push($strUsers, $user->id);
            }
        }

        if ($auctionGuard && !empty($strUsers)) {
            $client = new \GuzzleHttp\Client();
            $guardNotification = $client->post('http://5.101.123.41/guard/set', [
                'form_params' => [
                    'token' => '2323GDSJfdspoqwVc12',
                    'time_left' => $auctionTimeLeft,
                    'time_left_past_time' => Carbon::now()->timestamp,
                    'time_last_interval' => $auctionTimeLastInterval,
                    'auction_id' => $auctionId,
                    'users' => implode(',', $strUsers),
                    'from' => $auctionGuard->from,
                    'to' => $auctionGuard->to,
                    'current_user' => $currentUser,
                ]
            ]);
        }
        //$guardNotification->getBody()->getContents(); //show result
    }

    /**
     * Метод получения по 3 аукциона из указанных категорий
     *
     * @return array
     */
    public static function auctionCategoryItems()
    {
        $auctionCategorySlug = [
            'currency',
            'certificates',
            'electronics',
            'gadgets',
        ];
        $auctionCategory = AuctionCategory::whereIn('slug', $auctionCategorySlug)->orderBy('id', 'asc')->get();
        foreach ($auctionCategory as $auctionCategoryItem) {
            $arrayItems = Auction::where('category', $auctionCategoryItem->slug)->take(3)->get();
            $auctionCategoryItems[] = [
                'auctionCategory' => $auctionCategoryItem,
                'auctionItems' => $arrayItems,
            ];
        }

        return $auctionCategoryItems;
    }

    /**
     * Метод дополняет нулями id аукциона, чтобы получить номер лота фиксированной длинны
     *
     * @param $auctionId integer Идентификатор аукциона
     * @return string Число номера лота в виде строки
     */
    public static function getAuctionNumber($auctionId)
    {
        return sprintf("%'.06d\n", $auctionId);
    }

    /**
     * Получить имя пользователя, лидирующего в аукционе
     *
     * @param $auctionId integer Идентификатор аукциона
     * @return boolean | User
     */
    public static function getLeader($auctionId)
    {
        $leaderBid = Bid::where('auction_id', $auctionId)->orderby('id', 'desc')->first();
        if ($leaderBid) {
            return User::where('id', $leaderBid->user_id)->first();
        }
        return false;
    }
}
