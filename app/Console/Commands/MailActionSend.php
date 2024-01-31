<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\PayOrder;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MailActionSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:action:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail for actions';

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
        //alex.golovlyov@gmail.com
        //office@golovlyov.com
        //
        $users = User::where('confirmed', 1)->get();
        foreach ($users as $user) {
            \Mail::send('emails.new_year', [], function ($message) use ($user) {
                $message->to($user->email, $user->instagram)
                    ->subject('Новогоднее удвоение!');
            });
        }
    }
}
