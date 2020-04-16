<?php

namespace Tessify\Core\Events\User;

use App\Models\User;
use Tessify\Core\Models\Task;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserFollowsUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $targetUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, User $targetUser)
    {
        $this->user = $user;
        $this->targetUser = $targetUser;
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
