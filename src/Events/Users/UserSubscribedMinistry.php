<?php

namespace Tessify\Core\Events\Users;

use App\Models\User;
use Tessify\Core\Models\Ministry;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserSubscribedMinistry
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $ministry;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Ministry $ministry)
    {
        $this->user = $user;
        $this->ministry = $ministry;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
