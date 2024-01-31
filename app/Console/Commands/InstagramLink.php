<?php

namespace App\Console\Commands;

use App\Http\InstaHelper;
use App\Models\InstagramServer;
use App\Models\Notification;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstagramLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instagram:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create instagram photo and check instagram register';

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
            $newTime = 20;
            $time = $time - $newTime;
            if ($time >= 0) {
                sleep($newTime);
                $this->instaUpdate();
            }
        }
    }

    public function instaUpdate()
    {
        $servers = InstagramServer::get();

        $users = User::whereNull('instagram_id')->where('is_ban', '!=', 1)->orderBy('id', 'desc')->take(count($servers))->get();
        $count = 0;
        foreach ($users as $user) {
            if ($user->photo == null || $user->photo == 0) {
                $this->saveInstaData($user);
                $count++;
            }
        }
        var_dump('over');
    }

    public function saveInstaData($user)
    {
        $instagramServers = InstagramServer::get();
        foreach ($instagramServers as $server) {
            $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $wait = $this->isWaitServer($server, $now);
            if (!$wait && $server->request_count >= 200) {
                $server->request_count = 0;
                $server->save();
            }
            if ($this->canSendRequest($now, $server->id)) {
                var_dump($user->email);
                var_dump('request');

                $dataInsta = InstaHelper::getInstaData($user->instagram, $server->ip);
                $server->last_request_date = $now;
                $server->request_count = $server->request_count + 1;
                $server->save();

                var_dump($dataInsta);
                if ($dataInsta == 'ERROR') {
                    $server->request_count = 200;
                    $server->message = 'ERROR';
                    $server->off = 'ERROR';
                    $server->save();
                    break;
                    //непредвиденная ошибка
                }
                if ($dataInsta !== "NOT FOUND") {
                    $dataInstaPhoto = InstaHelper::getInstaPhoto($dataInsta);
                    $dataInstaId = InstaHelper::getInstaId($dataInsta);
                    $otherId = User::where('instagram_id', $dataInstaId)->where('id', '!=', $user->id)->first();
                    if ($otherId) {
                        if ($user->active == 0) {
                            $this->deleteNotification($user);
                            $user->delete();
                        }
                    } else {
                        $user->photo = $dataInstaPhoto;
                        $user->instagram_id = $dataInstaId;
                        $user->save();
                    }
                } else if ($dataInsta == "NOT FOUND") {
                    if ($user->active == 0) {
                        $this->deleteNotification($user);
                        $user->delete();
                    }
                }
                break;
            }
        }
    }

    public function canSendRequest($now, $id)
    {
        $server = InstagramServer::where('id', $id)->first();
        $timeInterval = date('Y-m-d H:i:s',
            strtotime('+' . $server['interval'] . ' seconds',
                strtotime($server['last_request_date'])));
        if ($timeInterval < $now && $server->request_count < 200) {
            return true;
        } else {
            return false;
        }
    }

    public function isWaitServer($server, $now)
    {
        $timeInterval = date('Y-m-d H:i:s',
            strtotime('+' . $server->request_time_wait . ' day',
                strtotime($server->last_request_date)));
        if ($timeInterval <= $now && $server->request_count == 200) {
            return false;
        } else {
            true;
        }
    }

    public function deleteNotification($user)
    {
        $notification = new Notification();
        $notification->name = 'Пользователь ' . $user->email . ' удален, причина нет Инстаграм или дубликат ' . $user->instagram . ' было ставок ' . $user->bid;
        $notification->type = 'delete';
        $notification->item_type = 'none';
        $notification->already_send = 1;
        $notification->save();
    }
}
