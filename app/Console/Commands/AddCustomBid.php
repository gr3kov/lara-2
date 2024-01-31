<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Notification;
use App\Models\PayOrder;
use App\Models\UserBidAdd;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddCustomBid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:custom:bid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add bid for user - custom';

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
        $bids = UserBidAdd::where('success', 0)->get();
        foreach ($bids as $bid) {
            if ($bid->shop) {
                $description = 'Товар: ' . $bid->shop->name . ', кто купил: id ' . $bid->user->id . ' email ' . $bid->user->email . ' card';
                $orderID = mt_rand(5000, 945000000);
                $newOrder = new PayOrder();

                $newOrder->order = $orderID;
                $newOrder->sber_order = $orderID;
                $newOrder->user_id = $bid->user->id;
                $newOrder->price = $bid->shop->price;
                $newOrder->shop_id = $bid->shop->id;
                $newOrder->status = 'create';
                $newOrder->sber_message = '';
                $newOrder->success = 1;
                $newOrder->add_bid = 1;
                $newOrder->description = $description;
                $newOrder->save();

                $user = User::where('id', $bid->user_id)->first();
                $user->bid = $user->bid + $bid->shop->count;
                $user->save();

                $notification = new Notification();
                $notification->name = 'Покупка ' . $bid->shop->name . ' ' . $bid->user->id . ' на карту. Начислено вручную';
                $notification->item_id = $bid->shop->id;
                $notification->user_id = $bid->user->id;
                $notification->type = 'pay';
                $notification->item_type = 'shop';
                $notification->already_send = 0;
                $notification->save();

                $bid->success = 1;
                $bid->save();
            } else {
                if ($bid->price) {
                    $description = 'Товар: ' . $bid->bid . ' ставок, кто купил: id ' . $bid->user->id . ' email ' . $bid->user->email . ' card';
                    $orderID = mt_rand(5000, 945000000);
                    $newOrder = new PayOrder();
                    var_dump($bid->price);
                    $newOrder->order = $orderID;
                    $newOrder->sber_order = $orderID;
                    $newOrder->user_id = $bid->user->id;
                    $newOrder->price = $bid->price;
                    $newOrder->shop_id = null;
                    $newOrder->status = 'create';
                    $newOrder->sber_message = '';
                    $newOrder->success = 1;
                    $newOrder->add_bid = 1;
                    $newOrder->description = $description;
                    $newOrder->save();

                    $user = User::where('id', $bid->user_id)->first();
                    $user->bid = $user->bid + $bid->bid;
                    $user->save();

                    $notification = new Notification();
                    $notification->name = 'Покупка ставок ' . $bid->bid . ' ' . $bid->user->id . ' на карту. Начислено вручную';
                    $notification->user_id = $bid->user->id;
                    $notification->type = 'pay';
                    $notification->item_type = 'custom';
                    $notification->already_send = 0;
                    $notification->save();

                    $bid->success = 1;
                    $bid->save();
                }
            }
        }
    }
}
