<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Auction;
use App\User;

class AuctionDeleteMessegeSent implements ShouldBroadcast
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

    public function __construct(Auction $auction, Notification $notification = null)
    {
        $this->auction = $auction;
        $this->notification = $notification;
    }

    public function broadcastOn()
    {
        return ['auction_delete'];
    }

    public function broadcastAs()
    {
        return 'auction_delete';
    }
}
