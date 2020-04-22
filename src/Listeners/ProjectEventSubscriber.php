<?php

namespace Tessify\Core\Listeners;

use Reputation;
use FeedActivities;
use ReviewRequests;

class ProjectEventSubscriber
{
    public function subscribe($events)
    {
        // CRUD operations
        $events->listen('Tessify\Core\Events\Projects\ProjectCreated', 'Tessify\Core\Listeners\ProjectEventSubscriber@handleProjectCreated');
        $events->listen('Tessify\Core\Events\Projects\ProjectUpdated', 'Tessify\Core\Listeners\ProjectEventSubscriber@handleProjectUpdated');
        $events->listen('Tessify\Core\Events\Projects\ProjectDeleted', 'Tessify\Core\Listeners\ProjectEventSubscriber@handleProjectDeleted');

        // Progression
        $events->listen('Tessify\Core\Events\Projects\ProjectCompleted', 'Tessify\Core\Listeners\ProjectEventSubscriber@handleProjectCompleted');
    }

    public function handleProjectCreated($event)
    {
        // Award reputation points
        Reputation::givePoints(1000, "created_project", $event->project);
    }

    public function handleProjectUpdated($event)
    {
        // Create an activity feed entry for all the project's subscribers
        foreach ($event->project->subscribers as $subscriber)
        {
            FeedActivities::create("project_updated", $event->project, $event->user);
        }
    }

    public function handleProjectDeleted($event)
    {
        // Create an activity feed entry for all the project's subscribers
        foreach ($event->project->subscribers as $subscriber)
        {
            FeedActivities::create("project_deleted", $event->project, $event->user);
        }
    }

    public function handleProjectCompleted($event)
    {
        // Loop through all of the project's subscribed users
        foreach ($event->project->subscribers as $subscriber)
        {
            // Create an activity feed entry for all the project's subscribers
            FeedActivites::create("project_completed", $event->project, $subscriber);
        }

        // Loop through all of the project's team members
        foreach ($event->project->teamMembers as $teamMember)
        {
            // Ask all of the team members to review the project (owner)
            ReviewRequests::createForProject($event->project, "review_project", $teamMember->user);
            
            // Ask the project's author to review each team member
            ReviewRequests::createForUser($teamMember->user, "review_project_team_member", $event->project->author);
            
            // Award each team member reputation points
            Reputation::givePoints(1000, "completed_project", $event->project);
        }
        
        // Award the project author reputation points
        Reputation::givePoints(1000, "completed_project", $event->project);
    }
}