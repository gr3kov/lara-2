<?php

namespace App\Console\Commands;

use App\Models\ActiveUsers;
use App\Models\Bid;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ActiveUsersFill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'active:user:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'user stats active';

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
        $bidsToday = Bid::whereDate('created_at', '=', Carbon::today()->toDateString())->distinct('user_id')->count('user_id');
        $bidsHour = Bid::where('created_at', '>', Carbon::now()->subHours(1)->toDateTimeString())->distinct('user_id')->count('user_id');
        $bidsHalfHour = Bid::where('created_at', '>', Carbon::now()->subMinutes(30)->toDateTimeString())->distinct('user_id')->count('user_id');
        $bids15Minutes = Bid::where('created_at', '>', Carbon::now()->subMinutes(15)->toDateTimeString())->distinct('user_id')->count('user_id');

        $activeStats = ActiveUsers::first();
        if (!$activeStats) {
            $activeStats = new ActiveUsers();
        }
        $activeStats->per_15_min = $bids15Minutes;
        $activeStats->per_half = $bidsHalfHour;
        $activeStats->per_hour = $bidsHour;
        $activeStats->today = $bidsToday;
        $activeStats->save();
    }
}
