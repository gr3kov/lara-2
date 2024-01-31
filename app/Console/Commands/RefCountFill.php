<?php

namespace App\Console\Commands;

use App\Models\PayOrder;
use App\Models\RefCount;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RefCountFill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ref:count:fill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill ref table';

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
        RefCount::truncate();
        $users = User::where('confirmed', 1)->get();
        foreach ($users as $user) {
            $referrals = User::where('confirmed', 1)
                ->where('referrals_id', $user->id)->get();
            $this->fillRefByUser($user, $referrals);
        }
    }

    private function fillRefByUser($user, $referrals)
    {
        foreach ($referrals as $referral) {
            $firstSum = $this->getFirstPay($referral);
            RefCount::updateOrCreate([
                'user_id' => $user->id,
                'user_id_ref' => $referral->id,
                'first_sum' => isset($firstSum) ? $firstSum->price : null,
                'pay_at' => isset($firstSum) ? $firstSum->updated_at : null,
            ]);
        }
    }

    private function getFirstPay($referral)
    {
        $order = PayOrder::where('success', 1)
            ->orderBy('updated_at', 'asc')->where('user_id', $referral->id)
            ->where('price', '>', 1)->first();
        return $order;
    }
}
