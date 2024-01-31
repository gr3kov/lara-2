<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\PayOrder;
use App\Models\UserBidStats;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\UserStats;

class BidFailHandling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bid:fail:return';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'return failed bid';

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
        $auction = Auction::find(1216);
//        $auction->payed = 0;
//        $auction->save();
        var_dump($auction->name);
        var_dump("Время завершения аукциона по GMT: "
            . $auction->updated_at->toDateTimeString());
        var_dump("Последние 5 ставок");
        $bids = Bid::where('auction_id', $auction->id)->orderBy('id', 'desc')->take(5)->get();
        foreach ($bids as $bid) {
            var_dump('Кто: '
                . User::find($bid->user_id)->instagram . 'время ставки: '
                . $bid->updated_at->toDateTimeString());
        }
    }
}
