<?php

namespace App\Console\Commands;

use App\Events\AuctionMessageSent;
use App\Helpers\AuctionHelper;
use App\Models\Auction;
use App\Models\Autobid;
use App\Models\Bid;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AutobidStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autobid:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'autobid start';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $time = 60;
        while ($time > 0) {
            $newTime = 1;
            $time = $time - $newTime;
            if ($time >= 0) {
                sleep($newTime);
                $this->autobidSet();
            }
        }
//        $this->autobidSet();
    }

    public function autobidSet()
    {
        $auctionLots = Auction::where('status_id', 2)->get();
        foreach ($auctionLots as $auction) {
            $currentTime = date('Y-m-d H:i:s');
            $lastAuctionBid = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->first();
            $autobids = Autobid::where('active', 1)->where('auction_id', $auction->id)
                ->where('date_time_start', '<', $currentTime)
                ->where('date_time_stop', '>', $currentTime)
                ->where('user_id', '<>', $lastAuctionBid->user_id)->get();
            $time_diff = strtotime($auction->time_last_interval) - strtotime($currentTime);
            $countAutobid = count($autobids);
            if ($countAutobid > 0) {
                $randomUserNumber = rand(0, $countAutobid - 1);
                $userID = $autobids[$randomUserNumber]->user_id;

                $user = User::find($userID);
                $bid = $user->bid;

                if ($bid > 0) {
                    $this->autobidDo($auction, $autobids[$randomUserNumber], $user, $time_diff);
                } else {
                    $autobids[$randomUserNumber]->active = 0;
                    $autobids[$randomUserNumber]->save();
                }
            }
        }
    }

    public function autobidDo($auction, $autobid, $user, $time_diff)
    {
        $next_time = $autobid->next_time_sec ? $autobid->next_time_sec : 60;
        $timeRandom = rand($autobid->last_time_sec, $next_time);
        if ($timeRandom >= $time_diff) {
            $bids = Bid::where('auction_id', $auction->id)->orderby('id', 'desc')->get();
            if ($bids[0]->user_id == $user->id) {
                //cant
            } else {
                $time = date('Y-m-d H:i:s',
                    strtotime('+' . $auction->interval_time . ' seconds',
                    strtotime(date('Y-m-d H:i:s'))));

                $priceNew = $auction->price + 1;
                $bid = new Bid();
                $bid->auction_id = $auction->id;
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

                $user->bid = $user->bid - 1; //или другое количество
                $user->save();

                event(new AuctionMessageSent($auction, $user));
                AuctionHelper::sendMessageToGuard($auction, $user->id);
            }
        }
    }
}
