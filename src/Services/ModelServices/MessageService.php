<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Users;
use App\Models\User;
use Tessify\Core\Models\Message;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Messages\SendMessageRequest;

class MessageService implements ModelServiceContract
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
        // Relationships
        $instance->sender = Users::findPreloaded($instance->sender_id);
        $instance->receiver = Users::findPreloaded($instance->receiver_id);
        $instance->reply_to = $this->find($instance->reply_to_id);

        // View href
        $instance->view_href = route('messages.read', $instance->uuid);

        return $instance;
    }
    
    public function findByUuid($uuid)
    {
        foreach ($this->getAll() as $message)
        {
            if ($message->uuid == $uuid)
            {
                return $message;
            }
        }

        return false;
    }

    public function findPreloadedByUuid($uuid)
    {
        foreach ($this->getAllPreloaded() as $message)
        {
            if ($message->uuid == $uuid)
            {
                return $message;
            }
        }

        return false;
    }

    public function numUnread(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $out = 0;

        if ($user)
        {
            foreach ($this->getAll() as $message)
            {
                if ($message->receiver_id == $user->id and !$message->read)
                {
                    $out += 1;
                }
            }
        }

        return $out;
    }

    public function receivedMessages(User $user = null)
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

    public function sentMessages(User $user = null)
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

    public function sendFromRequest(SendMessageRequest $request, Message $replyTo = null)
    {
        $user = Auth::user();

        return Message::create([
            "sender_id" => $user->id,
            "receiver_id" => $request->receiver_id,
            "reply_to_id" => is_null($replyTo) ? 0 : $replyTo->id,
            "subject" => $request->subject,
            "message" => $request->message,
        ]);
    }
    
    public function markAsRead(Message $message)
    {
        $message->read = true;
        $message->save();

        return $message;
    }
}