<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Notification;
use App\Models\UsersNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\User;

class CreateNotificationList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:list:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create notification list';

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
        $time = 60;
        while ($time > 0) {
            $newTime = 2;
            $time = $time - $newTime;
            if ($time >= 0) {
                sleep($newTime);
                $this->createNotificationList();
            }
        }
    }

    private function createNotificationList()
    {
        $users = User::get();
        $notifications = Notification::where('already_send', 0)->get();
        foreach ($notifications as $notification) {
            $usersNotification = UsersNotification::where('notification_id', $notification->id)->first();
            if (!$usersNotification) {
                foreach ($users as $user) {
                    $userNotification = new UsersNotification();
                    $userNotification->notification_id = $notification->id;
                    $userNotification->user_id = $user->id;
                    $userNotification->is_show = 0;
                    $userNotification->save();
                }
                $notification->already_send = 1;
                $notification->save();
            }
        }
    }
}
