<?php

namespace App\Console\Commands;

use App\Helpers\AuctionHelper;
use App\Helpers\TextHelper;
use App\Http\Controllers\sms\SMSController;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\User;

class AuctionLotStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:lot:time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change time and status';

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
                $this->auctionUpdate();
            }
        }
    }

    private function auctionUpdate()
    {
        $auctions = Auction::where('status_id', 2)->get();
        foreach ($auctions as $auction) {
            if ($auction->time_last_interval !== null) {
                $time_to_completed = strtotime($auction->time_last_interval);
                $time_to_completed_sec = date('H:i:s', $time_to_completed);
                $time_to_completed_carbon = \Carbon\Carbon::parse($time_to_completed_sec)->format('Y-m-d H:i:s');
                $current_time = date('H:i:s');
                $current_time_carbon = \Carbon\Carbon::parse($current_time)->format('Y-m-d H:i:s');
                $time_diff = strtotime($auction->time_last_interval) - strtotime(date('Y-m-d H:i:s'));
                if ($time_diff <= 0) {
                    $leaderId = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->first();
                    $leader = User::find($leaderId->user_id);

                    $notification = new Notification();
                    $notification->name = 'Лидер в борьбе за ' . $auction->name . ' ' . $leader->instagram . ' время завершения: ' . $time_to_completed_carbon . ' текущее время: ' . $current_time_carbon;
                    $notification->item_id = $auction->id;
                    $notification->type = 'winner';
                    $notification->user_id = $leader->id;
                    $notification->item_type = 'auction';
                    $notification->already_send = 0;
                    $notification->save();

                    $auction->status_id = 3;
                    $auction->save();

                    if ($leader->delivery_phone && $auction->category !== 'bid') {
                        $phone = TextHelper::phoneFormat($leader->delivery_phone);
                        if ($phone) {
                            $smsController = new SMSController();
                            $message = 'Поздравляем вас с победой лота ' . AuctionHelper::getAuctionNumber($auction->id) . ' "' . $auction->name . '”. Убедитесь что в разделе «профиль» верно заполнены данные для доставки! Не забудьте, что на выкуп лота даётся 14 дней после победы аукциона, после чего лот будет перезапущен автоматически!';
                            $smsController->index($message, $phone);
                        }
                    }
                }
            }
        }
    }
}
