<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\PayOrder;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddActive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user:active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add active flag to user';

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
