<?php

namespace App\Console\Commands;

use App\Events\AuctionMessageSent;
use App\Helpers\AuctionHelper;
use App\Models\Auction;
use App\Models\Bid;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Notification;

class StartLot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:auction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auction start';

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
            $newTime = 2;
            $time = $time - $newTime;
            if ($time >= 0) {
                sleep($newTime);
                $this->startAuction();
            }
        }
    }

    public function startAuction()
    {
        $auctions = Auction::where('time_to_start', '<=', Carbon::now()->format('Y-m-d H:i:s'))->whereIn('status_id', [1, 2])->orderBy('id', 'desc')->get();
        foreach ($auctions as $auction) {
            $notificationAuction = Notification::where('type', 'new-auction')->where('item_id', $auction->id)->first();
            if (!$notificationAuction) {
                $notification = new Notification();
                $notification->name = 'Новый лот ' . $auction->name;
                $notification->item_id = $auction->id;
                $notification->type = 'new-auction';
                $notification->item_type = 'auction';
                $notification->already_send = 1;
                $notification->save();

                $bid = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->first();
                if ($bid) {
                    $user = User::find($bid->user_id);
                } else {
                    $user = null;
                }
                event(new AuctionMessageSent($auction, $user, $notification));
                AuctionHelper::sendMessageToGuard($auction, $user->id);
            }
        }
    }
}
