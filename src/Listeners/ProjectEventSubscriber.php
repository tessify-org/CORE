<?php

namespace Tessify\Core\Listeners;

use Reputation;

class ProjectEventSubscriber
{
    public function handleProjectCreated($event)
    {
        Reputation::givePoints(1000, "created_project", $event->project);
    }

    public function handleProjectCompleted($event)
    {
        Reputation::givePoints(1000, "completed_project", $event->project);
    }

    public function subscribe($events)
    {
        $events->listen('Tessify\Core\Events\Projects\ProjectCreated', 'Tessify\Core\Listeners\ProjectEventSubscriber@handleProjectCreated');
        $events->listen('Tessify\Core\Events\Projects\ProjectCompleted', 'Tessify\Core\Listeners\ProjectEventSubscriber@handleProjectCompleted');
    }
}