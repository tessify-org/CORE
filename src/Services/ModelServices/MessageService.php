<?php

namespace Tessify\Core\Services\ModelServices;

use App\Models\User;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Messages\SendMessageRequest;

class MessageService extends ModelService
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Message";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function getNumUnread(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $out = 0;

        foreach ($this->getAll() as $message)
        {
            if ($message->receiver_id == $user->id and !$message->read)
            {
                $out++;
            }
        }

        return $out;
    }

    public function getReceivedMessages(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $out = [];

        foreach ($this->getAllPreloaded() as $message)
        {
            if ($message->receiver_id == $user->id)
            {
                $out[] = $message;
            }
        }

        return collect($out);
    }

    public function getSentMessages(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $out = [];

        foreach ($this->getAllPreloaded() as $message)
        {
            if ($message->sender_id == $user->id)
            {
                $out[] = $message;
            }
        }

        return collect($out);
    }

    public function sendFromRequest(SendMessageRequest $request)
    {

    }
}