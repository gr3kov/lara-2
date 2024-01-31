<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Notification;
use App\Models\PayOrder;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FrodDetection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:frod:detection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Frod detection and ban';

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
        $users = User::get();
        foreach ($users as $user) {
            $user->save();
            $this->isActive($user); //проверки на активность
        }
        $usersNotActive = User::where('active', 0)->get();
        foreach ($usersNotActive as $user) {
            $haveAccount = User::where('reg_ip', $user->reg_ip)->where('active', 0)->get();
            if (count($haveAccount) > 1) {
                foreach ($haveAccount as $account) {
                    $account->bid = 0;
                    $account->is_ban = 1;
                    $account->save();

                    $notification = new Notification();
                    $notification->name = 'Пользователь ' . $account->email . ' заблокирован причина мультаккаунт';
                    $notification->type = 'ban';
                    $notification->user_id = $account->id;
                    $notification->item_type = 'none';
                    $notification->already_send = 1;
                    $notification->save();
                }
            }
        }
    }

    public function isActive($user)
    {
        if ($user->active == 1) {
            return true;
        } else {
            return $this->checkActiveViaOrder($user);
        }
    }

    public function checkActiveViaOrder($user)
    {
        $payOrder = PayOrder::where('user_id', $user->id)->where('success', 1)
            ->where('add_bid', 1)
            ->first();
        if ($payOrder) {
            $user->active = 1;
            $user->save();
            return true;
        } else {
            return false;
        }
    }
}
