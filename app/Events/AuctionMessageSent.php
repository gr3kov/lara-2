<?php

namespace App\Events;

use App\Models\Notification;
use App\UserPusher;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Auction;

class AuctionMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Message detailsPrivateChannel
     *
     * @var Message
     */
    public $auction;

    public $user;

    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct(Auction      $auction,
                                $user = null,
                                Notification $notification = null)
    {
        $userPusher = UserPusher::find($user->id);
        $this->auction = $auction;
        $this->user = $userPusher;
        /*$this->user->name='test name user';
        $this->user['name']='test name user 2';*/
        $this->notification = $notification;
    }

    public function broadcastOn()
    {
        return [env('PUSHER_CHANNEL')];
    }

    public function broadcastAs()
    {
        return env('PUSHER_EVENT');
    }
}
