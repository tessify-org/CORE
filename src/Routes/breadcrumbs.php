<?php

//
// Frontend Breadcrumbs
//

// Home
Breadcrumbs::for("home", function($t) {
    $t->push(__('tessify-core::breadcrumbs.home'), route("home"));
});

// Register
Breadcrumbs::for("auth.register", function($t) {
    $t->parent("home");
    $t->push(__('tessify-core::breadcrumbs.register'), route("auth.register"));
});

// Login
Breadcrumbs::for("auth.login", function($t) {
    $t->parent("home");
    $t->push(__('tessify-core::breadcrumbs.login'), route("auth.login"));
});

// Forgot password
Breadcrumbs::for("auth.forgot-password", function($t) {
    $t->parent("auth.login");
    $t->push(__('tessify-core::breadcrumbs.forgot_password'), route("auth.forgot-password"));
});

// Reset password
Breadcrumbs::for("auth.reset-password", function($t, $data) {
    $t->parent("auth.forgot-password");
    $t->push(__('tessify-core::breadcrumbs.reset_password'), route("auth.reset-password", ["code" => $data["code"], "email" => $data["email"]]));
});

// Search
Breadcrumbs::for("search", function($t) {
    $t->parent("home");
    $t->push(__('tessify-core::breadcrumbs.search'), route("search"));
});

// Memberlist
Breadcrumbs::for("memberlist", function($t) {
    $t->parent("home");
    $t->push(__('tessify-core::breadcrumbs.memberlist'), route("memberlist"));
}); 

// Profile
Breadcrumbs::for("profile", function($t, $user) {
    $t->parent("home");
    $t->push(__('tessify-core::breadcrumbs.profile', ['name' => $user->formattedName]), route('profile', $user->slug));
});
Breadcrumbs::for("profile.update", function($t, $user) {
    $t->parent("profile", $user);
    $t->push(__('tessify-core::breadcrumbs.profile_update'), route("profile.update"));
});

// Projects
Breadcrumbs::for("projects", function($t) {
    $t->parent("home");
    $t->push(__('tessify-core::breadcrumbs.projects'), route("projects"));
});
Breadcrumbs::for("projects.view", function($t, $project) {
    $t->parent("projects");
    $t->push(__('tessify-core::breadcrumbs.projects_view'), route("projects.view", $project->slug));
});
Breadcrumbs::for("projects.create", function($t) {
    $t->parent("projects");
    $t->push(__('tessify-core::breadcrumbs.projects_create'), route("projects.create"));
});
Breadcrumbs::for("projects.edit", function($t, $project) {
    $t->parent("projects.view", $project);
    $t->push(__('tessify-core::breadcrumbs.projects_update'), route("projects.edit", $project->slug));
});
Breadcrumbs::for("projects.delete", function($t, $project) {
    $t->parent("projects.view", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_delete"), route("projects.delete", $project->slug));
});

// Project teams
Breadcrumbs::for("projects.team.view", function($t, $project) {
    $t->parent("projects.view", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_team_view"), route("projects.team.view", $project->slug));
});
Breadcrumbs::for("projects.team.leave", function($t, $project) {
    $t->parent("projects.team.view", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_team_leave"), route("projects.team.leave", $project->slug));
});

// Project team applications
Breadcrumbs::for("projects.team.applications", function($t, $project) {
    $t->parent("projects.view", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_team_applications"), route("projects.team.applications", $project->slug));
});
Breadcrumbs::for("projects.team.applications.view", function($t, $project, $application) {
    $t->parent("projects.team.applications", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_team_applications_view"), route("projects.team.applications.view", ["slug" => $project->slug, "uuid" => $application->uuid]));
});
Breadcrumbs::for("projects.team.applications.edit", function($t, $project, $application) {
    $t->parent("projects.team.applications.view", $project, $application);
    $t->push(__("tessify-core::breadcrumbs.projects_team_applications_edit"), route("projects.team.applications.edit", ["slug" => $project->slug, "uuid" => $application->uuid]));
});
Breadcrumbs::for("projects.team.applications.delete", function($t, $project, $application) {
    $t->parent("projects.team.applications.view", $project, $application);
    $t->push(__("tessify-core::breadcrumbs.projects_team_applications_delete"), route("projects.team.applications.delete", ["slug" => $project->slug, "uuid" => $application->uuid]));
});

Breadcrumbs::for("projects.team.apply", function($t, $project) {
    $t->parent("projects.view", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_team_apply"), route("projects.team.apply", $project->slug));
});

// Project team members
Breadcrumbs::for("projects.team.change-roles", function($t, $project, $user) {
    $t->parent("projects.team.view", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_team_change_roles"), route("projects.team.change-roles", ["slug" => $project->slug, 'userSlug' => $user->slug]));
});
Breadcrumbs::for("projects.team.remove-member", function($t, $project, $user) {
    $t->parent("projects.view", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_team_member_remove"), route("projects.team.remove-member", ['slug' => $project->slug, 'userSlug' => $user->slug]));
});
Breadcrumbs::for("projects.team.invite-member", function($t, $project) {
    $t->parent("projects.view", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_team_member_invite"), route("projects.team.invite-member", $project->slug));
});

// Project team roles
Breadcrumbs::for("projects.team.roles.create", function($t, $project) {
    $t->parent("projects.team.view", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_team_role_create"), route("projects.team.roles.create", $project->slug));
});
Breadcrumbs::for("projects.team.roles.edit", function($t, $project, $role) {
    $t->parent("projects.team.view", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_team_role_update"), route("projects.team.roles.edit", ["slug" => $project->slug, "roleSlug" => $role->slug]));
});
Breadcrumbs::for("projects.team.roles.delete", function($t, $project, $role) {
    $t->parent("projects.team.view", $project);
    $t->push(__("tessify-core::breadcrumbs.projects_team_role_delete"), route("projects.team.roles.delete", ["slug" => $project->slug, "roleSlug" => $role->slug]));
});

// Projects > Tasks
Breadcrumbs::for("projects.tasks", function($t, $project) {
    $t->parent("projects.view", $project);
    $t->push(__('tessify-core::breadcrumbs.project-tasks'), route("projects.tasks", $project->slug));
});

//
// Admin Panel Breadcrumbs
//

// Dashboard
Breadcrumbs::for("admin.dashboard", function($t) {
    $t->push(__('tessify-core::breadcrumbs.admin_dashboard'), route("admin.dashboard"));
});