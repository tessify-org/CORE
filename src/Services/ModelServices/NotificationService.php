<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use App\Models\User;
use Tessify\Core\Models\Notification;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class NotificationService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Notification";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function numUnread(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();
        
        $out = 0;

        if ($user)
        {
            foreach ($this->getAll() as $notification)
            {
                if ($notification->user_id == $user->id and !$notification->read)
                {
                    $out += 1;
                }
            }
        }

        return $out;
    }

    public function getUnread(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();
        
        $out = [];

        foreach ($this->getAll() as $notification)
        {
            if ($notification->user_id == $user->id and !$notification->read)
            {
                $out[] = $notification;
            }
        }

        return collect($out);
    }

    public function get(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();
        
        $out = [];

        foreach ($this->getAll() as $notification)
        {
            if ($notification->user_id == $user->id)
            {
                $out[] = $notification;
            }
        }

        return collect($out);
    }

    public function create($title, $description = null, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        return Notification::create([
            "user_id" => $user->id,
            "title" => $title,
            "description" => $description,
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->read = true;
        $notification->read_on = now()->format("Y-m-d H:m:s");
        $notification->save();
    }

    public function markAllAsRead(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        foreach ($this->get($user) as $notification)
        {
            if (!$notification->read)
            {
                $this->markAsRead($notification);
            }
        }
    }

    public function clear(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        foreach ($this->get($user) as $notification)
        {
            $notification->delete();
        }
    }
}