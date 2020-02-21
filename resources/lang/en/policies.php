<?php

/*
|--------------------------------------------------------------------------
| Policy Language Lines
|--------------------------------------------------------------------------
| 
| The following language lines are used throughout the policies the CORE
| package provides.
|
*/

return [

    //
    // Project policy
    //

    "update_deny" => "You don't have permission to update this project.",
    "delete_deny" => "You don't have permission to delete this project.",
    "status_deny" => "You don't have permission to update this project's status.",
    "manage_team_roles_deny" => "You don't have permission to manage this project's team roles.",
    "manage_team_applications_deny" => "You don't have permission to manage this project's team applications.",
    "manage_team_members_deny" => "You don't have permission to manage this project's team members.",
    "apply_for_team_deny_owner" => "You can't apply for a role as you are the owner of this project.",
    "apply_for_team_deny_team_member" => "You can't apply for a role as you are already on this project's team.",
    "apply_for_team_deny_application_exists" => "You already have an outstanding application that's awaiting processing.",
    "leave_team_deny" => "You can only leave this team if you're a part of it.",

];
