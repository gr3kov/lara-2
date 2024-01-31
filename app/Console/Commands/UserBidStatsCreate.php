<?php

namespace App\Console\Commands;

use App\Models\Bid;
use App\Models\PayOrder;
use App\Models\UserBidStats;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\UserStats;

class UserBidStatsCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:bid:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'user bid stats count';

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
        $users = User::where('active', 1)->get();
        foreach ($users as $user) {
            $userId = $user->id;
            $sum = PayOrder::where('success', 1)->where('add_bid', 1)
                ->where('user_id', $userId)->sum('price');
            $userBidStats = UserBidStats::where('user_id', $userId)->first();
            $bidSpent = Bid::where('user_id', $userId)->sum('bid_spend');
            if (!$userBidStats) {
                $userBidStats = new UserBidStats();
            }
            $userBidStats->user_id = $userId;
            $userBidStats->instagram = $user->instagram;
            $userBidStats->current_bid = $user->bid;
            $userBidStats->buy_bid = 0;
            $userBidStats->bid_spent = $bidSpent;
            $userBidStats->income = $sum;
            $userBidStats->save();
        }
    }
}
