<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\Notification;
use App\Models\PayOrder;
use App\Models\Shop;
use App\Models\SiteConfig;
use App\Models\UsersNotification;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Http\Controllers\MoneyController;

class OperationHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-bid:yandex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create bid for users';

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
        $moneyController = new MoneyController();
        $operations = $moneyController->accountHistory(0, 100);

        foreach ($operations->operations as $operation) {
            $details = $moneyController->getOperationDetails($operation->operation_id);
            if ($details->status == "success") {
                $label = "";
                if (isset($details->label)) $label = $details->label;
                if ($label != "") {
                    $user = User::where('id', '=', $label)->first();
                    if ($user != null) {
                        if ($details->message) {
                            $orderID = str_replace(['Imperial Аукцион', ';'], '', $details->message);
                            $payOrder = PayOrder::where('order', trim($orderID))->first();
                            $shopElement = Shop::find($payOrder['shop_id']);
                            $auctionElement = Auction::find($payOrder['auction_id']);
                            if ($shopElement && $payOrder['add_bid'] == 0) {
                                $doubleBid = SiteConfig::where('code', 'double-pay-bid')->where('value', 'on')->first();
                                $newBid = $shopElement->count;
                                $messageConfig = '';

                                if (isset($doubleBid)) {
                                    $newBid = $shopElement->count * 2;
                                    $messageConfig = 'Бонус удвоения';
                                }
                                $user->bid = $user->bid + $newBid;
                                $payOrder->success = 1;
                                $payOrder->add_bid = 1;
                                $payOrder->save();
                                $user->save();

                                $notification = new Notification();
                                $notification->name = 'Покупка ставок ' . $shopElement->name . ' ' . $user->id . ' яндекс. ' . $messageConfig;
                                $notification->item_id = $shopElement->id;
                                $notification->user_id = $user->id;
                                $notification->type = 'pay';
                                $notification->item_type = 'shop';
                                $notification->already_send = 0;
                                $notification->save();
                            } else if ($auctionElement && $payOrder['add_bid'] == 0) {
                                $payOrder->success = 1;
                                $payOrder->add_bid = 1;
                                $payOrder->save();

                                $notification = new Notification();
                                $notification->name = 'Покупка лота ' . $auctionElement->name . ' ' . $user->id . ' яндекс. ';
                                $notification->item_id = $auctionElement->id;
                                $notification->user_id = $user->id;
                                $notification->type = 'pay';
                                $notification->item_type = 'auction';
                                $notification->already_send = 0;
                                $notification->save();

                                if ($auctionElement->category == 'bid' && $auctionElement->bid) {
                                    $bid = $auctionElement->bid > 0 ? $auctionElement->bid : 0;
                                    $user->bid = $user->bid + $bid;
                                    $user->save();

                                    $notification = new Notification();
                                    $notification->name = 'Автоматическое начисление ставок ' . $auctionElement->name . ' ' . $user->id . ' количество ' . $bid;
                                    $notification->item_id = $auctionElement->id;
                                    $notification->user_id = $user->id;
                                    $notification->type = 'add-bid';
                                    $notification->item_type = 'auction';
                                    $notification->already_send = 0;
                                    $notification->save();
                                }

                                $updated_at = $auctionElement->updated_at;
                                $auctionElement->payed = 1;
                                $auctionElement->leader_id = $user->id;
                                $auctionElement->updated_at = $updated_at;
                                $auctionElement->save();
                            }
                        }
                    }
                }
            }
        }
    }
}
