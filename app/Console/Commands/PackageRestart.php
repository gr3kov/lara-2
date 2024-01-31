<?php

namespace App\Console\Commands;

use App\Events\AuctionDeleteMessegeSent;
use App\Models\Auction;
use App\Models\PayOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\Notification;
use Carbon\Carbon;
use App\Models\Bid;

class PackageRestart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:restart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'package restart';

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
        $currentTime = '2020-06-14 08:52:00.000000';
        $auctions = Auction::where('category', 'bid')
            ->where('status_id', 3)
            ->where('restart_flag', 0)
            ->where('payed', 0)
            ->where('created_at', '>', $currentTime)->get();
        foreach ($auctions as $auction) {
            $order = PayOrder::where('auction_id', $auction->id)->first();
            $needRestart = false;
            if (!$order) {
                $needRestart = true;
            } else if ($order->success == 0) {
                $needRestart = true;
            }

            if ($needRestart) {
                $this->packageBidRestart($auction);
            }
        }
    }

    private function packageBidRestart($auction)
    {
        $date = date("Y-m-d H:i:s");
        $time = strtotime($date);
        $time = $time - (40 * 60);
        $dateMinus40 = date("Y-m-d H:i:s", $time);

        if ($auction->updated_at <= $dateMinus40) {
            $auction->updated_at = Carbon::now()->subDays(10)->toDateTimeString();
            $auction->restart_flag = 1;
            $auction->save();

            event(new AuctionDeleteMessegeSent($auction));

            $bid = Bid::where('auction_id', $auction->id)->orderBy('id', 'asc')->first();
            $price = $auction->price;
            if ($bid) {
                $price = $bid->new_price - 1;
            }

            $auctionItem = new Auction();
            $auctionItem->name = $auction->name;
            $auctionItem->images = $auction->images;
            $auctionItem->characteristic = $auction->characteristic;
            $auctionItem->description = $auction->description;
            $auctionItem->price = $price;
            $auctionItem->interval_time = $auction->interval_time;
            $auctionItem->start_time = $auction->start_time;
            $auctionItem->status_id = 1;
            $auctionItem->preview_image = $auction->preview_image;
            $auctionItem->category = $auction->category;
            $auctionItem->time_to_start = $date;
            $auctionItem->start_time = $date;
            $auctionItem->bid = $auction->bid;
            $auctionItem->save();

            $notification = new Notification();
            $notification->name = 'Перезапуск лота ' . $auction->name . ' причина - не оплачен в течении 30 минут ';
            $notification->item_id = $auction->id;
            $notification->type = 'restart';
            $notification->item_type = 'auction';
            $notification->already_send = 0;
            $notification->save();
        }
    }
}
