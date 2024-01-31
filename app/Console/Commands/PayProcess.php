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
use SoapClient;
use Carbon\Carbon;

class PayProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pay:process';

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
        $orders = PayOrder::where('success', 0)->orderBy('id', 'desc')->
        where('created_at', '>', Carbon::now()->subHours(1)->toDateTimeString())->take(30)->get();
        foreach ($orders as $orderEl) {
            $moneyController = new MoneyController();
            $details = $moneyController->payProcess($orderEl);
            if ($details) {
                $moneyController->payCredit($details, $orderEl);
            }
        }
    }
}
