<?php 

/*
 |
 | Core Web Routes
 |
 */

// Layout element related endpoints
Route::post("switch-locales", "Translation\LocaleController@postSwitchLocale")->name("switch-locale.post");
Route::post("submit-bug-report", "System\BugReportController@postSubmitReport")->name("submit-bug-report.post");

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

    // Notifications
    Route::group(["prefix" => "notificaties"], function() {
        Route::get("/", "System\NotificationController@getOverview")->name("notifications");
        Route::get("clear", "System\NotificationController@getClear")->name("notifications.clear");
    });

    // Messages
    Route::group(["prefix" => "berichten"], function() {
        Route::get("/", "System\MessageController@getInbox")->name("messages");
        Route::get("outbox", "System\MessageController@getOutbox")->name("messages.outbox");
        Route::get("opstellen/{uuid?}", "System\MessageController@getSend")->name("messages.send");
        Route::post("opstellen/{uuid?}", "System\MessageController@postSend")->name("messages.send.post");
        Route::get("lezen/{uuid}", "System\MessageController@getRead")->name("messages.read");
    });

    // Memberlist
    Route::get("leden", "Profiles\MemberlistController@getMemberList")->name("memberlist");

    // Update profiel
    Route::get("profiel/updaten", "Profiles\ProfileController@getUpdateProfile")->name("profile.update");
    Route::post("profiel/updaten", "Profiles\ProfileController@postUpdateProfile")->name("profile.update.post");

    // Profiel
    Route::get("profiel/{slug?}", "Profiles\ProfileController@getProfile")->name("profile");
    Route::get("profiel/{slug}/follow", "Profiles\ProfileController@getFollow")->name("profile.follow");
    Route::get("profiel/{slug}/unfollow", "Profiles\ProfileController@getUnfollow")->name("profile.unfollow");
    Route::get("profiel/{slug}/request-access-to-email", "Profiles\ProfileController@getRequestAccessToEmail")->name("profile.request-access-email");
    Route::get("profiel/access-email-request/{messageUuid}/{requestUuid}/accept", "Profiles\ProfileController@getAcceptAccessEmailRequest")->name("profile.request-access-email.accept");
    Route::get("profiel/access-email-request/{messageUuid}/{requestUuid}/reject", "Profiles\ProfileController@getRejectAccessEmailRequest")->name("profile.request-access-email.reject");

    // Dashboard
    Route::get("dashboard", "Dashboard\DashboardController@getDashboard")->name("dashboard");
    
    // Settings
    Route::get("instellingen", "Settings\SettingsController@getSettings")->name("settings");
    
    // Get started
    Route::get("get-started", "Projects\ProjectController@getGetStarted")->name("get-started");

    // Projects
    Route::group(["prefix" => "projecten"], function() {
                
        // Manage projects
        Route::get("/", "Projects\ProjectController@getOverview")->name("projects");
        
        // Create
        Route::get("starten", "Projects\ProjectController@getCreate")->name("projects.create");
        Route::post("starten", "Projects\ProjectController@postCreate")->name("projects.create.post");

        // View
        Route::get("{slug}", "Projects\ProjectController@getView")->name("projects.view");

        // Edit
        Route::get("{slug}/aanpassen", "Projects\ProjectController@getEdit")->name("projects.edit");
        Route::post("{slug}/aanpassen", "Projects\ProjectController@postEdit")->name("projects.edit.post");

        // Delete
        Route::get("{slug}/verwijderen", "Projects\ProjectController@getDelete")->name("projects.delete");
        Route::post("{slug}/verwijderen", "Projects\ProjectController@postDelete")->name("projects.delete.post");

        // Subscribe & unsubscribe
        Route::get("{slug}/subscribe", "Projects\ProjectController@getSubscribe")->name("projects.subscribe");
        Route::get("{slug}/unsubscribe", "Projects\ProjectController@getUnsubscribe")->name("projects.unsubscribe");

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
        Route::get("{slug}/team/aanmeldingen/{uuid}/verwijderen", "Projects\ProjectTeamMemberApplicationController@getDelete")->name("projects.team.applications.delete");
        Route::post("{slug}/team/aanmeldingen/{uuid}/verwijderen", "Projects\ProjectTeamMemberApplicationController@postDelete")->name("projects.team.applications.delete.post");
        Route::get("{slug}/team/aanmeldingen/{uuid}/accepteren", "Projects\ProjectTeamMemberApplicationController@getAccept")->name("projects.team.applications.accept");
        Route::get("{slug}/team/aanmeldingen/{uuid}/afwijzen", "Projects\ProjectTeamMemberApplicationController@getReject")->name("projects.team.applications.reject");
        Route::get("{slug}/team/aanmeldingen/{uuid}/heropenen", "Projects\ProjectTeamMemberApplicationController@getReopen")->name("projects.team.applications.reopen");

        // Manage tasks
        Route::get("{slug}/werkpakketten", "Projects\ProjectTaskController@getOverview")->name("projects.tasks");
        
    });

    // Task overview
    Route::group(["prefix" => "werkpakketten"], function() {
        
        // Route::get("/", "Projects\TaskDashboardController@getOverview")->name("tasks");
        // Route::get("toevoegen", "Projects\TaskDashboardController@getCreate")->name("tasks.create");
        // Route::post("toevoegen", "Projects\TaskDashboardController@postCreate")->name("tasks.create.post");

        // Task dashboard / overview
        Route::get("/", "Projects\TaskController@getOverview")->name("tasks");

        // Create
        Route::get("toevoegen/{slug?}", "Projects\TaskController@getCreate")->name("tasks.create");
        Route::post("toevoegen/{slug?}", "Projects\TaskController@postCreate")->name("tasks.create.post");

        // View
        Route::get("{slug}", "Projects\TaskController@getView")->name("tasks.view");

        // Update
        Route::get("{slug}/aanpassen", "Projects\TaskController@getEdit")->name("tasks.edit");
        Route::post("{slug}/aanpassen", "Projects\TaskController@postEdit")->name("tasks.edit.post");

        // Delete
        Route::get("{slug}/verwijderen", "Projects\TaskController@getDelete")->name("tasks.delete");
        Route::post("{slug}/verwijderen", "Projects\TaskController@postDelete")->name("tasks.delete.post");

        // Assign to me
        Route::get("{slug}/aannemen", "Projects\TaskController@getAssignToSelf")->name("tasks.assign-to-me");

        // Abandon
        Route::get("{slug}/uitschrijven", "Projects\TaskController@getAbandon")->name("tasks.abandon");
        Route::post("{slug}/uitschrijven", "Projects\TaskController@postAbandon")->name("tasks.abandon.post");

        // Subscribe & unsubscribe
        Route::get("{slug}/volgen", "Projects\TaskController@getSubscribe")->name("tasks.subscribe");
        Route::get("{slug}/niet-meer-volgen", "Projects\TaskController@getUnsubscribe")->name("tasks.unsubscribe");

        // Report progress
        Route::get("{slug}/voortgang-rapporteren", "Projects\TaskController@getReportProgress")->name("tasks.report-progress");
        Route::post("{slug}/voortgang-rapporteren", "Projects\TaskController@postReportProgress")->name("tasks.report-progress.post");

        // Progress report
        Route::get("{slug}/voortgangsrapport/{uuid}", "Projects\TaskController@getProgressReport")->name("tasks.progress-report");

        // Review progress report
        Route::get("{slug}/voortgangsrapport/{uuid}/reviewen", "Projects\TaskController@getReviewProgressReport")->name("tasks.progress-report.review");
        Route::post("{slug}/voortgangsrapport/{uuid}/reviewen", "Projects\TaskController@postReviewProgressReport")->name("tasks.progress-report.review.post");

        // Complete
        Route::get("{slug}/voltooien", "Projects\TaskController@getComplete")->name("tasks.complete");
        
        // Invite friend
        Route::get("{slug}/iemand-uitnodingen", "Projects\TaskController@getInviteFriend")->name("tasks.invite");

        // Ask question
        Route::get("{slug}/vraag-stellen", "Projects\TaskController@getAskQuestion")->name("tasks.ask-question");
        
    });

    // Search
    Route::group(["prefix" => "zoeken"], function() {
        Route::get("/", "System\SearchController@getSearch")->name("search");
        Route::post("/", "System\SearchController@postSearch")->name("search.post");
        Route::group(["prefix" => "tags"], function() {
            Route::get("/", "System\TagController@getOverview")->name("tags");
            Route::get("{slug}", "System\TagController@getView")->name("tags.view");
        });
    });

    // Community
    Route::group(["prefix" => "community"], function() {
        
        // Overview
        Route::get("/", "Community\CommunityController@getOverview")->name("community");

        // Ministries
        Route::group(["prefix" => "ministeries"], function() {
            Route::get("/", "Community\MinistryController@getOverview")->name("ministries");
            Route::get("{slug}", "Community\MinistryController@getView")->name("ministries.view");
            Route::get("{slug}/volgen", "Community\MinistryController@getSubscribe")->name("ministries.subscribe");
            Route::get("{slug}/niet-meer-volgen", "Community\MinistryController@getUnsubscribe")->name("ministries.unsubscribe");
        });

        // Organizations
        Route::group(["prefix" => "organisaties"], function() {
            Route::get("/", "Community\OrganizationController@getOverview")->name("organizations");
            Route::get("{slug}", "Community\OrganizationController@getView")->name("organizations.view");
            Route::get("{slug}/volgen", "Community\OrganizationController@getSubscribe")->name("organizations.subscribe");
            Route::get("{slug}/niet-meer-volgen", "Community\OrganizationController@getUnsubscribe")->name("organizations.unsubscribe");
        });
        
        // Groups
        // Forum
        // Blogs
        // Polls
        // etc..

    });

    // Reviews
    Route::group(["prefix" => "reviews"], function() {

        // Requests
        Route::group(["prefix" => "verzoeken"], function() {

            // Accept request
            Route::get("{uuid}/accepteren", "Reviews\ReviewRequestController@getAccept")->name("reviews.requests.accept");

            // Reject request
            Route::get("{uuid}/afwijzen", "Reviews\ReviewRequestController@getReject")->name("reviews.requests.reject");

        });
        
        // My reviews
        Route::get("/", "Reviews\ReviewController@getOverview")->name("reviews");

        // Write review
        Route::get("schrijven/{type}/{slug}", "Reviews\ReviewController@getCreate")->name("reviews.create");
        Route::post("schrijven/{type}/{slug}", "Reviews\ReviewController@postCreate")->name("reviews.create.post");

        // Update review
        Route::get("aanpassen/{uuid}", "Reviews\ReviewController@getUpdate")->name("reviews.update");
        Route::post("aanpassen/{uuid}", "Reviews\ReviewController@postUpdate")->name("reviews.update.post");

        // Delete review
        Route::get("verwijderen/{uuid}", "Reviews\ReviewController@getDelete")->name("reviews.delete");
        Route::post("verwijderen/{uuid}", "Reviews\ReviewController@postDelete")->name("reviews.delete.post");
        
        // View review
        Route::get("{uuid}", "Reviews\ReviewController@getView")->name("reviews.view");

    });

});

// Admin panel
Route::group(["prefix" => "admin", "middleware" => ["can:access-admin-panel"]], function() {

    // Dashboard
    Route::get("/", "Admin\DashboardController@getDashboard")->name("admin.dashboard");

    // Manage users
    Route::group(["prefix" => "gebruikers-beheren"], function() {
        // Overview
        Route::get("/", "Admin\UserController@getOverview")->name("admin.users");
        // Create
        Route::get("create", "Admin\UserController@getCreate")->name("admin.users.create");
        Route::post("create", "Admin\UserController@postCreate")->name("admin.users.create.post");
        // View
        Route::get("{id}", "Admin\UserController@getView")->name("admin.users.view");
        // Update
        Route::get("{id}/edit", "Admin\UserController@getEdit")->name("admin.users.edit");
        Route::post("{id}/edit", "Admin\UserController@postEdit")->name("admin.users.edit.post");
        // Delete
        Route::get("{id}/delete", "Admin\UserController@getDelete")->name("admin.users.delete");
        Route::post("{id}/delete", "Admin\UserController@postDelete")->name("admin.users.delete.post");
        // Ban
        Route::get("{id}/ban", "Admin\UserController@getBan")->name("admin.users.ban");
        Route::post("{id}/ban", "Admin\UserController@postBan")->name("admin.users.ban.post");
        // Unban
        Route::get("{id}/unban", "Admin\UserController@getUnban")->name("admin.users.unban");
        // Flag as checked
        Route::get("{id}/flag-as-checked", "Admin\UserController@getFlagAsChecked")->name("admin.users.flag-as-checked");
        // Flag as unchecked
        Route::get("{id}/unflag-as-checked", "Admin\UserController@getFlagAsUnchecked")->name("admin.users.unflag-as-checked");
        // Change password
        Route::get("{id}/change-password", "Admin\UserController@getChangePassword")->name("admin.users.change-password");
        Route::post("{id}/change-password", "Admin\UserController@postChangePassword")->name("admin.users.change-password.post");
        // Send message
        Route::get("{id}/send-message", "Admin\UserController@getSendMessage")->name("admin.users.send-message");
        Route::post("{id}/send-message", "Admin\UserController@postSendMessage")->name("admin.users.send-message.post");
    });

    // Settings
    Route::group(["prefix" => "instellingen"], function() {

        // Overview
        Route::get("/", "Admin\SettingsController@getOverview")->name("admin.settings");

        // Authentication settings
        Route::get("authentication", "Admin\SettingsController@getAuthSettings")->name("admin.settings.auth");
        Route::post("authentication", "Admin\SettingsController@postAuthSettings")->name("admin.settings.auth.post");

    });

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

    // Profile
    Route::group(["prefix" => "profile"], function() {
        Route::post("upload-avatar", "Api\ProfileController@postUploadAvatar")->name("api.profile.upload-avatar.post");
        Route::post("upload-header-image", "Api\ProfileController@postUploadHeaderImage")->name("api.profile.upload-header-image.post");
    });

    // Newsletter
    Route::group(["prefix" => "newsletter"], function() {
        Route::post("signup", "Api\NewsletterController@postSignup")->name("api.newsletter.signup.post");
    });

    // Search
    Route::group(["prefix" => "search"], function() {
        Route::post("/", "Api\SearchController@postSearch")->name("api.search.post");
    });

});

// Static pages
Route::get("internet-explorer", "System\StaticPageController@getDontUseInternetExplorer")->name("system.dont-use-ie");

// Tests
Route::get("test-flash-notification", function() {
    flash("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut faucibus ullamcorper diam nec vulputate.")->success();
    return redirect()->route("home");
});

Route::group(["prefix" => "test"], function() {
    Route::get("search/{query}", "System\TestController@getTestSearch")->name("test.search");
});

// TODO: Move these to the api.php file and add proper token-based authentication instead of session hijacking like this