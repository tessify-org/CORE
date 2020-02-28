<?php 

/*
 |
 | Core Web Routes
 |
 */

// General endpoints
Route::post("switch-locales", "Translation\LocaleController@postSwitchLocale")->name("switch-locale.post");

// Guest only endpoints
Route::group(["middleware" => "guest"], function() {
    
    // Registration
    Route::get("register", "Auth\RegisterController@getRegister")->name("auth.register");
    Route::post("register", "Auth\RegisterController@postRegister")->name("auth.register.post");

    // Login
    Route::get("login", "Auth\LoginController@getLogin")->name("auth.login");
    Route::post("login", "Auth\LoginController@postLogin")->name("auth.login.post");

    // Forgot password
    Route::get("wachtwoord-vergeten", "Auth\ForgotPasswordController@getForgotPassword")->name("auth.forgot-password");
    Route::post("wachtwoord-vergeten", "Auth\ForgotPasswordController@postForgotPassword")->name("auth.forgot-password.post");

    // Reset password
    Route::get("wachtwoord-herstellen/{email}/{code}", "Auth\ResetPasswordController@getResetPassword")->name("auth.reset-password");
    Route::post("wachtwoord-herstellen/{email}/{code}", "Auth\ResetPasswordController@postResetPassword")->name("auth.reset-password.post");

});

// Auth endpoints, when user is logged in
Route::group(["middleware" => "auth"], function() {

    // Logout
    Route::get("uitloggen", "Auth\LogoutController@getLogout")->name("auth.logout");

    // Memberlist
    Route::get("ledenlijst", "Profiles\MemberlistController@getMemberList")->name("memberlist");

    // Update profiel
    Route::get("profiel/updaten", "Profiles\ProfileController@getUpdateProfile")->name("profile.update");
    Route::post("profiel/updaten", "Profiles\ProfileController@postUpdateProfile")->name("profile.update.post");

    // Profiel
    Route::get("profiel/{slug?}", "Profiles\ProfileController@getProfile")->name("profile");

    // Projects
    Route::group(["prefix" => "projecten"], function() {

        // Projects CRUD
        Route::get("/", "Projects\ProjectController@getOverview")->name("projects");
        Route::get("project-toevoegen", "Projects\ProjectController@getCreate")->name("projects.create");
        Route::post("project-toevoegen", "Projects\ProjectController@postCreate")->name("projects.create.post");
        Route::get("{slug}", "Projects\ProjectController@getView")->name("projects.view");
        Route::get("{slug}/aanpassen", "Projects\ProjectController@getEdit")->name("projects.edit");
        Route::post("{slug}/aanpassen", "Projects\ProjectController@postEdit")->name("projects.edit.post");
        Route::get("{slug}/verwijderen", "Projects\ProjectController@getDelete")->name("projects.delete");
        Route::post("{slug}/verwijderen", "Projects\ProjectController@postDelete")->name("projects.delete.post");
        
        // View team
        Route::get("{slug}/team", "Projects\ProjectTeamController@getView")->name("projects.team.view");
        
        // Apply for team role(s)
        Route::get("{slug}/team/aanmelden", "Projects\ProjectTeamMemberApplicationController@getCreate")->name("projects.team.apply");
        Route::post("{slug}/team/aanmelden", "Projects\ProjectTeamMemberApplicationController@postCreate")->name("projects.team.apply.post");
        
        // Leave team
        Route::get("{slug}/team/verlaten", "Projects\ProjectTeamController@getLeaveTeam")->name("projects.team.leave");
        Route::post("{slug}/team/verlaten", "Projects\ProjectTeamController@postLeaveTeam")->name("projects.team.leave.post");
        
        // Invite member to team
        Route::get("{slug}/team/uitnodigen", "Projects\ProjectTeamController@getInviteUser")->name("projects.team.invite-member");
        Route::post("{slug}/team/uitnodigen", "Projects\ProjectTeamController@postInviteUser")->name("projects.team.invite-member.post");

        // Remove member from team
        Route::get("{slug}/team/{userSlug}/verwijderen", "Projects\ProjectTeamController@getRemoveMember")->name("projects.team.remove-member");
        Route::post("{slug}/team/{userSlug}/verwijderen", "Projects\ProjectTeamController@postRemoveMember")->name("projects.team.remove-member.post");
        
        // Change roles
        Route::get("{slug}/team/{userSlug}/rol-veranderen", "Projects\ProjectTeamController@getChangeMemberRoles")->name("projects.team.change-roles");
        Route::post("{slug}/team/{userSlug}/rol-veranderen", "Projects\ProjectTeamController@postChangeMemberRoles")->name("projects.team.change-roles.post");

        // Manage team roles
        Route::get("{slug}/team/rollen/toevoegen", "Projects\ProjectTeamRoleController@getCreate")->name("projects.team.roles.create");
        Route::post("{slug}/team/rollen/toevoegen", "Projects\ProjectTeamRoleController@postCreate")->name("projects.team.roles.create.post");
        Route::get("{slug}/team/rollen/{roleSlug}/aanpassen", "Projects\ProjectTeamRoleController@getUpdate")->name("projects.team.roles.edit");
        Route::post("{slug}/team/rollen/{roleSlug}/aanpassen", "Projects\ProjectTeamRoleController@postUpdate")->name("projects.team.roles.edit.post");
        Route::get("{slug}/team/rollen/{roleSlug}/verwijderen", "Projects\ProjectTeamRoleController@getDelete")->name("projects.team.roles.delete");
        Route::post("{slug}/team/rollen/{roleSlug}/verwijderen", "Projects\ProjectTeamRoleController@postDelete")->name("projects.team.roles.delete.post");
        Route::get("{slug}/team/rollen/{roleSlug}/toewijzen-aan-mijzelf", "Projects\ProjectTeamRoleController@getAssignToMe")->name("projects.team.roles.assign-to-me");
        
        // Manage applications
        Route::get("{slug}/team/aanmeldingen", "Projects\ProjectTeamMemberApplicationController@getOverview")->name("projects.team.applications");
        Route::get("{slug}/team/aanmeldingen/{uuid}", "Projects\ProjectTeamMemberApplicationController@getView")->name("projects.team.applications.view");
        Route::get("{slug}/team/aanmeldingen/{uuid}/aanpassen", "Projects\ProjectTeamMemberApplicationController@getEdit")->name("projects.team.applications.edit");
        Route::post("{slug}/team/aanmeldingen/{uuid}/aanpassen", "Projects\ProjectTeamMemberApplicationController@postEdit")->name("projects.team.applications.edit.post");
        Route::get("{slug}/team/aanmeldingen/{uuid}/verwijderen", "Projects\ProjectTeamMemberApplicationControllerProjectTeamMemberApplicationController@getDelete")->name("projects.team.applications.delete");
        Route::post("{slug}/team/aanmeldingen/{uuid}/verwijderen", "Projects\ProjectTeamMemberApplicationController@postDelete")->name("projects.team.applications.delete.post");
        Route::get("{slug}/team/aanmeldingen/{uuid}/accepteren", "Projects\ProjectTeamMemberApplicationController@getAccept")->name("projects.team.applications.accept");
        Route::get("{slug}/team/aanmeldingen/{uuid}/afwijzen", "Projects\ProjectTeamMemberApplicationController@getReject")->name("projects.team.applications.reject");
        Route::get("{slug}/team/aanmeldingen/{uuid}/heropenen", "Projects\ProjectTeamMemberApplicationController@getReopen")->name("projects.team.applications.reopen");

        // Manage tasks
        Route::get("{slug}/taken", "Projects\TaskController@getOverview")->name("projects.tasks");
        Route::get("{slug}/taken/toevoegen", "Projects\TaskController@getCreate")->name("projects.tasks.create");
        Route::post("{slug}/taken/toevoegen", "Projects\TaskController@postCreate")->name("projects.tasks.create.post");
        Route::get("{slug}/taken/{taskSlug}", "Projects\TaskController@getView")->name("projects.tasks.view");
        Route::get("{slug}/taken/{taskSlug}/aanpassen", "Projects\TaskController@getEdit")->name("projects.tasks.edit");
        Route::post("{slug}/taken/{taskSlug}/aanpassen", "Projects\TaskController@postEdit")->name("projects.tasks.edit.post");
        Route::get("{slug}/taken/{taskSlug}/verwijderen", "Projects\TaskController@getDelete")->name("projects.tasks.delete");
        Route::post("{slug}/taken/{taskSlug}/verwijderen", "Projects\TaskController@postDelete")->name("projects.tasks.delete.post");

        Route::get("{slug}/taken/{taskSlug}/aannemen", "Projects\TaskController@getAssignToSelf")->name("projects.tasks.assign-to-me");
        Route::get("{slug}/taken/{taskSlug}/uitschrijven", "Projects\TaskController@getAbandon")->name("projects.tasks.abandon");
        Route::post("{slug}/taken/{taskSlug}/uitschrijven", "Projects\TaskController@postAbandon")->name("projects.tasks.abandon.post");

    });

    // Task overview
    Route::get("werk-paketten", "Projects\TaskDashboardController@getOverview")->name("tasks");
    
});

// Admin panel
Route::group(["prefix" => "admin", "middleware" => ["can:access-admin-panel"]], function() {

    // Dashboard
    Route::get("/", "Admin\DashboardController@getDashboard")->name("admin.dashboard");

});

// Api endpoints
Route::group(["prefix" => "api"], function() {

    // Locale
    Route::group(["prefix" => "locale"], function() {
        Route::post("set-active-locale", "Api\LocaleController@postSetActiveLocale")->name("api.locale.set-active.post");
    });

    // Project resources
    Route::group(["prefix" => "project-resources"], function() {
        Route::post("create", "Api\ProjectResourceController@postCreateResource")->name("api.projects.resources.create.post");
        Route::post("update", "Api\ProjectResourceController@postUpdateResource")->name("api.projects.resources.update.post");
        Route::post("delete", "Api\ProjectResourceController@postDeleteResource")->name("api.projects.resources.delete.post");
    });

    // Comments
    Route::group(["prefix" => "comments"], function() {
        Route::post("create", "Api\CommentController@postCreateComment")->name("api.comments.create.post");
        Route::post("update", "Api\CommentController@postUpdateComment")->name("api.comments.update.post");
        Route::post("delete", "Api\CommentController@postDeleteComment")->name("api.comments.delete.post");
    });

    // Team member applications
    Route::group(["prefix" => "team-member-applications"], function() {
        Route::post("create", "Api\TeamMemberApplicationController@postCreateApplication")->name("api.team-member-applications.create.post");
        Route::post("update", "Api\TeamMemberApplicationController@postUpdateApplication")->name("api.team-member-applications.update.post");
        Route::post("delete", "Api\TeamMemberApplicationController@postDeleteApplication")->name("api.team-member-applications.delete.post");
        Route::post("accept", "Api\TeamMemberApplicationController@postAcceptApplication")->name("api.team-member-applications.accept.post");
        Route::post("deny", "Api\TeamMemberApplicationController@postDenyApplication")->name("api.team-member-applications.deny.post");
    });

    // Team roles
    Route::group(["prefix" => "team-roles"], function() {
        Route::post("unassign", "Api\TeamRoleController@postUnassign")->name("api.team-roles.unassign");
    });
    
    // Assignments
    Route::group(["prefix" => "assignments"], function() {
        Route::post("create", "Api\AssignmentController@postCreateAssignment")->name("api.assignments.create.post");
        Route::post("update", "Api\AssignmentController@postUpdateAssignment")->name("api.assignments.update.post");
        Route::post("delete", "Api\AssignmentController@postDeleteAssignment")->name("api.assignments.delete.post");
    });

});
// TODO: Move these to the api.php file and add proper token-based authentication instead of session hijacking like this