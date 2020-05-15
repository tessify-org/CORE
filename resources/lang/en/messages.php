<?php

/*
|--------------------------------------------------------------------------
| Messages Language Lines
|--------------------------------------------------------------------------
| 
| The following language lines are used throughout the messages section of 
| the Tessify Core.
|
*/

return [

    //
    // General
    //
    
    "title" => "Messages",

    "message_not_found" => "Message could not be found",

    "nav_inbox" => "Inbox",
    "nav_outbox" => "Outbox",
    "nav_send" => "Send message",

    //
    // Inbox
    //

    "inbox_title" => "Received messages",
    "inbox_empty" => "You have not received any messages yet",

    //
    // Outbox
    //

    "outbox_title" => "Sent messages",
    "outbox_empty" => "You have not sent any messages yet",

    //
    // Send message
    //

    "send_title" => "Send message",
    "send_user" => "Recipient",
    "send_reply_to" => "In reply to",
    "send_subject" => "Subject",
    "send_message" => "Message",
    "send_submit" => "Send message",
    "send_back" => "Back to inbox",
    "message_sent" => "Succesfully sent message to :name!",
    "invalid_user" => "The given user could not be found",

    //
    // Read message
    //

    "read_title_sent" => "Sent message",
    "read_title_received" => "Received message",
    "read_sent_to" => "Sent to",
    "read_received_from" => "Received from",
    "read_subject" => "Subject",
    "read_message" => "Message",
    "read_back_inbox" => "Back to inbox",
    "read_back_outbox" => "Back to outbox",
    "read_reply" => "Reply",

    //
    // Requests
    //

    "request_action_accept" => "Accept",
    "request_action_deny" => "Reject",
    "request_accepted" => "You have accepted this request.",
    "request_rejected" => "You have rejected this request.",

    //
    // Invites
    //

    "project_invite_subject" => "Invitation for project",
    "project_invite_message" => "You have been invited by :user to join the :project project.",
    "project_invite_button" => "View project",

    "task_invite_subject" => "Invitiation for task",
    "task_invite_message" => "You have been invited by :user to join the :task task.",
    "task_invite_button" => "View task",

    "invitation_sent" => "Invitation has been sent!",
    "invitation_failed" => "Failed to send invitation.",


    //
    // Questions
    //

    "ask_project_question_subject" => "Question about project",
    "ask_project_question_message" => ":user has asked you the following question regarding the <strong>:project</strong> project: ':question'.",

    "ask_task_question_subject" => "Question about task",
    "ask_task_question_message" => ":user has asked you the following question regarding the <strong>:task</strong> task: ':question'.",
    
    "question_asked" => "Question has been asked!",
    "question_failed" => "Failed to ask question.",

    //
    // Kicked from ..
    //

    "kicked_from_project_team_subject" => "Kicked from project team",
    "kicked_from_project_team_message" => "You've been removed from the :project project's team.",
    "kicked_from_project_team_message_reason" => "You've been removed from the :project project's team. The reason for this is: :reason",

];