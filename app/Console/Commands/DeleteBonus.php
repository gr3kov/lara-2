<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DeleteBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bonus:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bonus delete';

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
        $count = 0;
        $users = User::where('created_at', '>', Carbon::now()->subDays(2)
            ->toDateTimeString())->where('active', 0)->get();
        foreach ($users as $user) {
            if ($user->bid <= 10 && $user->bid != 0) {
                $count = $count + $user->bid;
            }
        }
        var_dump($count);
    }
}
