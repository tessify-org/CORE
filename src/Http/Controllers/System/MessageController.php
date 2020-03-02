<?php

namespace Tessify\Core\Http\Controllers\System;

use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function getInbox()
    {
        return view("tessify-core::pages.system.messages.inbox", [

        ]);
    }

    public function getOutbox()
    {
        return view("tessify-core::pages.system.messages.outbox", []);
    }

    public function getSend()
    {

    }

    public function postSend(SendMessageRequest $request)
    {
        
    }

    public function getRead($uuid)
    {
        
    }
}