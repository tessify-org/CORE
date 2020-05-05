<?php

namespace Tessify\Core\Events\Projects;

use Tessify\Core\Models\Project;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $project;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Project $project, User $user = null)
    {
        $this->project = $project;
        $this->user = is_null($user) ? auth()->user() : $user;
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
