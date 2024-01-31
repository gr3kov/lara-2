<?php

namespace App\Console\Commands;

use App\Models\BidBonus;
use App\Models\BidDayStats;
use App\Models\PayOrder;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\BidStats;
use Carbon\Carbon;

class BidDayStatsCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bid:day:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'bid day stats count';

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
        $dateStart = Carbon::create(2019, 12, 18, 0);
        $dateEnd = Carbon::today();
        for (; $dateStart <= $dateEnd; $dateStart->addDay()) {
            $date = $dateStart->toDateString();
            $sum = PayOrder::where('success', 1)->where('add_bid', 1)
                ->whereDate('created_at', '=', $dateStart
                    ->toDateString())->sum('price');
            $register = User::whereDate('created_at', '=', $dateStart
                ->toDateString())->where('role_id', 3)->where('confirmed', 1)->get();
            $sumBidAuctions = PayOrder::where('success', 1)->where('add_bid', 1)
                ->where('description', 'like', '%став%')->whereDate('created_at', '=', $dateStart
                    ->toDateString());
//            $sumBidShop = PayOrder::where('success', 1)->where('add_bid', 1)
//                ->whereNotNull('shop_id')->whereDate('created_at', '=', $dateStart
//                ->toDateString());
            $bidIncome = $sumBidAuctions->sum('price');
            $bidDay = BidDayStats::where('date', $date)->first();

            if (!$bidDay) {
                $bidDay = new BidDayStats();
            }
            $bidDay->date = $date;
            $bidDay->income = $sum - $sumBidAuctions->sum('price');
            $bidDay->costs = 0;
            $bidDay->bid_income = $bidIncome;
            $bidDay->register = count($register);
            $bidDay->save();
        }
    }
}
