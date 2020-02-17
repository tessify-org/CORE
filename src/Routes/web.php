<?php 

/*
 |
 | Core Web Routes
 |
 */

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

        // Overview
        Route::get("/", "Projects\ProjectController@getOverview")->name("projects");

        // Create
        Route::get("project-toevoegen", "Projects\ProjectController@getCreate")->name("projects.create");
        Route::post("project-toevoegen", "Projects\ProjectController@postCreate")->name("projects.create.post");
        
        // View
        Route::get("{slug}", "Projects\ProjectController@getView")->name("projects.view");
        
        // Update
        Route::get("{slug}/aanpassen", "Projects\ProjectController@getEdit")->name("projects.edit");
        Route::post("{slug}/aanpassen", "Projects\ProjectController@postEdit")->name("projects.edit.post");
        
        // Delete
        Route::get("{slug}/verwijderen", "Projects\ProjectController@getDelete")->name("projects.delete");
        Route::post("{slug}/verwijderen", "Projects\ProjectController@postDelete")->name("projects.delete.post");
        
    });
    
});

// Admin panel
Route::group(["prefix" => "admin", "middleware" => ["can:access-admin-panel"]], function() {

    // Dashboard
    Route::get("/", "Admin\DashboardController@getDashboard")->name("admin.dashboard");

});

// Api endpoints
Route::group(["prefix" => "api"], function() {

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
    
});
// TODO: Move these to the api.php file and add proper token-based authentication instead of session hijacking like this