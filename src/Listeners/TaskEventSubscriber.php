<?php

namespace Tessify\Core\Listeners;

use Tasks;
use Reputation;
use FeedActivities;

class TaskEventSubscriber
{
    public function subscribe($events)
    {
        // CRUD events
        $events->listen('Tessify\Core\Events\Tasks\TaskCreated', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskCreated');
        $events->listen('Tessify\Core\Events\Tasks\TaskUpdated', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskUpdated');
        $events->listen('Tessify\Core\Events\Tasks\TaskDeleted', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskDeleted');
        
        // Assignments
        $events->listen('Tessify\Core\Events\Tasks\TaskAssigned', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskAssigned');
        $events->listen('Tessify\Core\Events\Tasks\TaskUnassigned', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskUnassigned');

        // Progression
        $events->listen('Tessify\Core\Events\Tasks\TaskCompleted', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskCompleted');
        $events->listen('Tessify\Core\Events\Tasks\TaskProgressReported', 'Tessify\Core\Listeners\TaskEventSubscriber@handleTaskProgressReported');
    }

    public function handleTaskCreated($event)
    {
        // Award the logged in user the "task created" reputation reward
        Reputation::givePoints(1000, "created_task", $event->task);
    }

    public function handleTaskUpdated($event)
    {
        // Create an activity feed entry for all the project's subscribers
        foreach ($event->task->subscribers as $subscriber)
        {
            FeedActivities::create("task_updated", $event->task, auth()->user());
        }
    }

    public function handleTaskDeleted($event)
    {
        // Create an activity feed entry for all the project's subscribers
        foreach ($event->task->subscribers as $subscriber)
        {
            FeedActivities::create("task_deleted", $event->task, auth()->user());
        }
    }

    public function handleTaskAssigned($event)
    {
        // Award the logged in user the "task assigned to you" reputation reward
        Reputation::givePoints(100, "assigned_to_task", $event->task);
    }

    public function handleTaskUnassigned($event)
    {
        // Take points from the user because they bailed out
        Reputation::takePoints(100, "unassigned_from_task", $event->task);
    }

    public function handleTaskCompleted($event)
    {
        // Create an activity feed entry for all the project's subscribers
        foreach ($event->task->subscribers as $subscriber)
        {
            FeedActivities::create("task_completed", $event->task, auth()->user());
        }

        // Award all assigned users the "task completed" reputation reward
        foreach ($event->task->users as $user)
        {
            $points = Reputation::determinePoints($event->task->urgency);

            Reputation::givePoints($points, "completed_task", $event->task, auth()->user());
        }

        // Detach all users from the completed task (as records are now being kept by the CompletedTask entries in the db)
        Tasks::unassignAllUsers($event->task);
    }
    
    public function handleTaskProgressReported($event)
    {
        // Award the logged in user the "reported progress on task" reputation reward
        Reputation::givePoints(100, "reported_progress_on_task", $event->task);
    }
}