<?php

namespace App\Console\Commands;

use App\Models\NotificationsNews;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NotificationNewsShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:news:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add count to notifiactions';

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
        $news = NotificationsNews::where('shown', 0)->get();
        $count = count($news);
        if ($count > 0) {
            $users = User::where('confirmed', 1)->get();
            foreach ($users as $user) {
                $user->notification_count = $user->notification_count + $count;
                $user->save();
            }
        }
        foreach ($news as $element) {
            $element->shown = 1;
            $element->save();
        }
    }
}
