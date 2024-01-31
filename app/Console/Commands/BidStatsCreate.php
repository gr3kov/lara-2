<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\BidBonus;
use App\Models\PayOrder;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\BidStats;
use App\Models\Shop;

class BidStatsCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bid:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'bid stats count';

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
        $bidStats = BidStats::first();
        if (!$bidStats) {
            $bidStats = new BidStats();
        }
        $payOrder = PayOrder::where('success', 1)->get();
        $users = User::where('role_id', '<>', 1)->get();
        $bidBonus = BidBonus::get();
        $bonus = 0;
        $allBidsPay = 0;
        foreach ($payOrder as $order) {
            $allBidsPay = $allBidsPay + $order->price;
        }
        $allBidInSystem = 0;
        foreach ($users as $user) {
            $allBidInSystem = $allBidInSystem + $user->bid;
        }
        foreach ($bidBonus as $bid) {
            $bonus = $bonus + $bid->bid_count;
        }
        $bidStats->all_bids = $allBidInSystem;
        $bidStats->all_price = $allBidsPay;
        $bidStats->bonus_bids = $bonus;
        $bidStats->bid_costs = $this->sumBidCosts();
        $bidStats->costs = 0;
        $bidStats->save();
    }

    private function sumBidCosts()
    {
        $sumBidAuctions = PayOrder::where('success', 1)->where('add_bid', 1)
            ->where('description', 'like', '%став%')->where('price', '>', 10);
        $sumBidShop = PayOrder::where('success', 1)->where('add_bid', 1)
            ->whereNotNull('shop_id')->where('price', '>', 10);
        $allSum = $sumBidAuctions->sum('price') + $sumBidShop->sum('price');

        $bidCount = 0;
        foreach ($sumBidAuctions->get() as $order) {
            $auctionLot = Auction::find($order->auction_id);
            if ($auctionLot) {
                if ($auctionLot->bid > 0) {
                    $bidCount = $bidCount + $auctionLot->bid;
                }
            }
        }
        foreach ($sumBidShop->get() as $order) {
            $shop = Shop::find($order->shop_id);
            if ($shop->count > 0) {
                $bidCount = $bidCount + $shop->count;
            }
        }
        return round($allSum / $bidCount, 2);
    }
}
