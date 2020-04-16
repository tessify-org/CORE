<?php

namespace Tessify\Core\Listeners;

use Users;
use FeedActivities;

class UserEventSubscriber
{
    public function subscribe($events)
    {
        // Task related events
        $events->listen('Tessify\Core\Events\Users\UserCreatedTask', 'Tessify\Core\Listeners\UserEventSubscriber@handleTaskCreated');
        $events->listen('Tessify\Core\Events\Users\UserUpdatedTask', 'Tessify\Core\Listeners\UserEventSubscriber@handleTaskUpdated');
        $events->listen('Tessify\Core\Events\Users\UserFollowsTask', 'Tessify\Core\Listeners\UserEventSubscriber@handleTaskFollowed');
        $events->listen('Tessify\Core\Events\Users\UserUnfollowsTask', 'Tessify\Core\Listeners\UserEventSubscriber@handleTaskUnfollowed');

        // Project related events
        $events->listen('Tessify\Core\Events\Users\UserCreatedProject', 'Tessify\Core\Listeners\UserEventSubscriber@handleProjectCreated');
        $events->listen('Tessify\Core\Events\Users\UserUpdatedProject', 'Tessify\Core\Listeners\UserEventSubscriber@handleProjectUpdated');
        $events->listen('Tessify\Core\Events\Users\UserFollowsProject', 'Tessify\Core\Listeners\UserEventSubscriber@handleProjectFollowed');
        $events->listen('Tessify\Core\Events\Users\UserUnfollowsProject', 'Tessify\Core\Listeners\UserEventSubscriber@handleProjectUnfollowed');

        // User related events
        $events->listen('Tessify\Core\Events\Users\UserFollowsUser', 'Tessify\Core\Listeners\UserEventSubscriber@handleUserFollowed');
        $events->listen('Tessify\Core\Events\Users\UserUnfollowsUser', 'Tessify\Core\Listeners\UserEventSubscriber@handleUserUnfollowed');
        $events->listen('Tessify\Core\Events\Users\UserLeftComment', 'Tessify\Core\Listeners\UserEventSubscriber@handleCommentLeft');
        $events->listen('Tessify\Core\Events\Users\UserUpdatedProfile', 'Tessify\Core\Listeners\UserEventSusbcriber@handleUpdatedProfile');
    }
    
    public function handleTaskCreated($event)
    {
        // Create an activity feed entry for all the user's followers
        foreach ($event->user->followers as $subscriber)
        {
            FeedActivities::create("user_created_task", $event->task, $event->user);
        }
    }   

    public function handleTaskUpdated($event)
    {
        // Create an activity feed entry for all the user's followers
        foreach ($event->user->followers as $subscriber)
        {
            FeedActivities::create("user_updated_task", $event->task, $event->user);
        }
    }

    public function handleTaskFollowed($event)
    {
        // Create an activity feed entry for all the user's followers
        foreach ($event->user->followers as $subscriber)
        {
            FeedActivities::create("user_followed_task", $event->task, $event->user);
        }
    }   

    public function handleTaskUnfollowed($event)
    {
        // Create an activity feed entry for all the user's followers
        foreach ($event->user->followers as $subscriber)
        {
            FeedActivities::create("user_unfollowed_task", $event->task, $event->user);
        }
    }

    public function handleProjectCreated($event)
    {
        // Create an activity feed entry for all the user's followers
        foreach ($event->user->followers as $subscriber)
        {
            FeedActivities::create("user_created_project", $event->project, $event->user);
        }
    }

    public function handleProjectUpdated($event)
    {
        // Create an activity feed entry for all the user's followers
        foreach ($event->user->followers as $subscriber)
        {
            FeedActivities::create("user_updated_project", $event->project, $event->user);
        }
    }

    public function handleProjectFollowed($event)
    {
        // Create an activity feed entry for all the user's followers
        foreach ($event->user->followers as $subscriber)
        {
            FeedActivities::create("user_followed_project", $event->project, $event->user);
        }
    }

    public function handleProjectUnfollowed($event)
    {

    }

    public function handleUserFollowed($event)
    {
        // Create an activity feed entry for all the user's followers
        foreach ($event->user->followers as $subscriber)
        {
            FeedActivities::create("user_followed_user", $event->targetUser, $event->user);
        }
    }

    public function handleUserUnfollowed($event)
    {
        
    }

    public function handleCommentLeft($event)
    {
        // Create an activity feed entry for all the user's followers
        foreach ($event->user->followers as $subscriber)
        {
            FeedActivities::create("user_commented", $event->comment, $event->user);
        }
    }
    
    public function handleUpdatedProfile($event)
    {
        // Create an activity feed entry for all the user's followers
        foreach ($event->user->followers as $subscriber)
        {
            FeedActivities::create("user_updated_profile", $event->user);
        }
    }
}