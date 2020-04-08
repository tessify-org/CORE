<?php

namespace Tessify\Core\Http\Controllers\System;

use Auth;
use Users;
use Messages;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Messages\SendMessageRequest;

class MessageController extends Controller
{
    public function getInbox()
    {
        return view("tessify-core::pages.system.messages.inbox", [
            "messages" => Messages::receivedMessages(),
        ]);
    }

    public function getOutbox()
    {
        return view("tessify-core::pages.system.messages.outbox", [
            "messages" => Messages::sentMessages(),
        ]);
    }

    public function getSend($uuid = null)
    {
        $replyTo = null;
        if (!is_null($uuid))
        {
            $message = Messages::findByUuid($uuid);
            if ($message) $replyTo = $message;
        }

        return view("tessify-core::pages.system.messages.send", [
            "replyTo" => $replyTo,
            "users" => Users::getAllPreloaded(),
            "oldInput" => collect([
                "user" => old("user"),
                "subject" => old("subject"),
                "message" => old("message"),
            ])
        ]);
    }

    public function postSend(SendMessageRequest $request, $uuid = null)
    {
        $replyTo = null;
        if (!is_null($uuid))
        {
            $message = Messages::findByUuid($uuid);
            if ($message) $replyTo = $message;
        }

        $message = Messages::sendFromRequest($request, $replyTo);

        flash(__("tessify-core::messages.message_sent", ["name" => $message->receiver->formattedName]))->success();
        return redirect()->route("messages");
    }
    
    public function getRead($uuid)
    {
        $message = Messages::findByUuid($uuid);
        if (!$message)
        {
            flash(__("tessify-core::messages.message_not_found"))->error();
            return redirect()->route("messages");
        }

        $state = Auth::user()->id == $message->sender_id ? "sender" : "receiver";

        Messages::markAsRead($message);

        return view("tessify-core::pages.system.messages.read", [
            "message" => $message,
            "state" => $state,
        ]);
    }
}