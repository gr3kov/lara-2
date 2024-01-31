<?php

namespace App\Console\Commands;

use App\Models\BidBonus;
use App\Models\BidDayStats;
use App\Models\CookieToUrl;
use App\Models\PayOrder;
use App\Models\TargetRegister;
use App\Models\UsersToUrl;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\BidStats;
use Carbon\Carbon;

class TargetRegisterStatsCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'target:register:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'traffic stats';

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
//        $userN = User::where('email', 'samikhajlov@gmail.com')->first();
//        $userN->role_id = 1;
//        $userN->save();
        //TargetRegister::query()->truncate();
        $dateStart = Carbon::yesterday();
        $dateEnd = Carbon::today();
        for (; $dateStart <= $dateEnd; $dateStart->addDay()) {
            $date = $dateStart->toDateString();
            $targets = CookieToUrl::whereDate('created_at', '=', $dateStart
                ->toDateString())->get()->unique('target');
            foreach ($targets as $targetObj) {
                if ($targetObj->target == 1 || $targetObj->target == 2) { //пропускаем неименной трафик
                    continue;
                }
                $urls = CookieToUrl::where('target', $targetObj->target)
                    ->whereDate('created_at', '=', $dateStart
                        ->toDateString())
                    ->distinct('url')->get();
                foreach ($urls as $url) {
                    $visitors = CookieToUrl::where('target', $targetObj->target)
                        ->whereDate('created_at', '=', $dateStart
                            ->toDateString())
                        ->where('url', $url->url)->count();
                    $users = UsersToUrl::where('target', $targetObj->target)
                        ->whereDate('created_at', '=', $dateStart->toDateString())
                        ->where('url', $url->url);
                    $usersArr = [];
                    $countActive = 0;
                    $sumUser = 0;
                    $incomeCount = 0;
                    foreach ($users->get() as $user) {
                        array_push($usersArr, $user->user_id);
                        $payOrder = PayOrder::where('success', 1)->where('add_bid', 1)
                            ->whereDate('created_at', '=', $dateStart->toDateString())
                            ->where('user_id', $user->user_id);
                        $sum = $payOrder->sum('price');
                        $countSum = $payOrder->get();
                        $incomeCount = $incomeCount + $countSum->count();
                        $sumUser = $sumUser + $sum;
                        if ($payOrder->first()) {
                            $countActive++;
                        }
                    }

                    $targetRegister = TargetRegister::
                    where('target', $targetObj->target)
                        ->where('date', $date)
                        ->where('source', $url->url)->first();
                    if (!$targetRegister) {
                        $targetRegister = new TargetRegister();
                    }
                    $usersCount = $users->count();
                    if ($visitors > 0 || $sum > 0 || $usersCount > 0) {
                        $targetRegister->date = $date;
                        $targetRegister->target = $targetObj->target;
                        $targetRegister->source = $url->url;
                        $targetRegister->visitor = $visitors;
                        $targetRegister->income = $sumUser;
                        $targetRegister->income_count = $incomeCount;
                        $targetRegister->active_visitors = $countActive;
                        $targetRegister->register = $usersCount;
                        $targetRegister->save();
                    }
                }
            }
        }
    }
}
