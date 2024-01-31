<?php

namespace App\Http\Controllers;

use App\Helpers\AuctionHelper;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;
use App\User;
use App\Events\AuctionMessageSent;

class GuardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function bid(Request $request)
    {
        $data = $request->all();
        $id = $data['auction_id'];
        $user = User::where('id', $data['user_id'])->first();
        $auction = Auction::where('id', $id)->where('status_id', 2)->first();
        if ($auction) {
            $bids = Bid::where('auction_id', $id)->orderby('id', 'desc')->get();
            if ($bids[0]->user_id == $user->id) {
                $data['error'] = 'Нельзя перебить свою ставку';
                return $data;
            } else {
                $time = date('Y-m-d H:i:s',
                    strtotime('+' . $auction['interval_time'] . ' seconds',
                        strtotime(date('Y-m-d H:i:s'))));

                $priceNew = $auction->price + 1;

                $bid = new Bid();
                $bid->auction_id = $id;
                $bid->user_id = $user->id;
                $bid->time_to_left = $time;
                $bid->new_price = $priceNew;
                $bid->auction_code = $auction->id . '-' . (count($bids) + 1); //далее + 1
                $bid->bid_spend = "1"; //потрачено
                $bid->save();

                $auction->time_last_interval = $time;
                $auction->price = $priceNew;
                $auction->time_left = $auction->interval_time; //сначала только интервал
                $auction->save();

                event(new AuctionMessageSent($auction, $user));
                AuctionHelper::sendMessageToGuard($auction, $user->id);

                $data['bids'] = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->take(10)->get();
                $data['auction'] = $auction;
                $data['user'] = $user->name;
                $data['user_bid'] = $user->bid;
                $data['user_photo'] = $user->photo;
            }

            return $data;
        } else {
            $data['error'] = 'Аукцион уже завершен';
            return $data;
        }
    }
}
