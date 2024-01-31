<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\UserStats;

class UserStatsCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'user stats count';

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
        $userStats = UserStats::first();
        if (!$userStats) {
            $userStats = new UserStats();
        }
        $allUsers = User::get();
        $activeUsers = User::where('active', 1)->get();
        $haveInstaUsers = User::whereNotNull('instagram_id')->get();
        $userStats->all = count($allUsers);
        $userStats->active = count($activeUsers);
        $userStats->have_insta = count($haveInstaUsers);
        $userStats->save();
    }
}
