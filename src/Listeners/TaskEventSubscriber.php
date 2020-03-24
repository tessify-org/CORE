<?php

namespace Tessify\Core\Listeners;

use Tasks;
use Reputation;

class TaskEventSubscriber
{
    public function handleTaskCreated($event)
    {
        Reputation::givePoints(1000, "created_task", $event->task);
    }

    public function handleTaskCompleted($event)
    {
        Reputation::givePoints(1000, "completed_task", $event->task);
    }
    
    public function handleTaskProgressReported($event)
    {
        Reputation::givePoints(100, "reported_progress_on_task", $event->task);
    }

    public function handleTaskAssigned($event)
    {
        Reputation::givePoints(100, "assigned_to_task", $event->task);
    }

    public function handleTaskUnassigned($event)
    {
        Reputation::takePoints(100, "unassigned_from_task", $event->task);
    }

    public function subscribe($events)
    {
        // Task created
        $events->listen('Tessify\Core\Events\Tasks\TaskCreated', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskCreated');

        // Task completed
        $events->listen('Tessify\Core\Events\Tasks\TaskCompleted', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskCompleted');

        // Task progress reported
        $events->listen('Tessify\Core\Events\Tasks\TaskProgressReported', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskProgressReported');
        
        // Task assigned (to user)
        $events->listen('Tessify\Core\Events\Tasks\TaskAssigned', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskAssigned');
        
        // Task unassigned (from user)
        $events->listen('Tessify\Core\Events\Tasks\TaskUnassigned', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskUnassigned');
    }
}