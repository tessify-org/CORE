<?php

/*
|--------------------------------------------------------------------------
| Projects Language Lines
|--------------------------------------------------------------------------
| 
| The following language lines are used throughout the profile pages.
|
*/

return [

    //
    // General
    //

    'project_created' => 'Project has been added.',
    'project_deleted' => 'Project has been deleted.',
    'project_not_found' => 'Project could not be found.',
    
    'team_role_not_found' => 'Team role could not be found.',
    'team_role_created' => 'Team role has been added to the project.',
    'team_role_updated' => 'Team role has been succesfully updated.',
    'team_role_deleted' => 'Team role has been succesfully removed.',

    'project_navigation_info' => 'Project information',
    'project_navigation_team' => 'The Team',
    'project_navigation_applications' => 'Applications',
    'project_navigation_tasks' => 'Tasks',

    'team_member_not_found' => 'Team member could not be found',

    'task_not_found' => 'Task could not be found',

    'progress_report_not_found' => 'Progression report could not be found',

    //
    // Overview
    //

    "overview_title" => "Projects",
    "overview_subtitle" => "Currently :num_projects projects registered!",
    "overview_create_cta" => "Start a project yourself!",
    "overview_description" => "Description",
    "overview_view" => "View project",
    "overview_no_projects" => "No projects",

    "overview_sidebar_search" => "Search",
    "overview_sidebar_statuses" => "Status",
    "overview_sidebar_statuses_hint" => "Indicates the state the task is currently in",
    "overview_sidebar_statuses_empty" => "No statuses found",
    "overview_sidebar_categories" => "Category",
    "overview_sidebar_categories_hint" => "Indicates what kind of task you can expect",
    "overview_sidebar_categories_empty" => "No categories found",

    "overview_table_title" => "Title",
    "overview_table_status" => "Status",
    "overview_empty" => "Be the first to add a project to this platform!",
    "overview_create_button" => "Start project",
    
    // 
    // View project
    // 

    "view_description" => "Project description",
    "view_owner" => "Owner",
    "view_details" => "Details",
    "view_resources" => "Resources",
    "view_no_resources" => "No resources have been added to this project",
    "view_category" => "Category",
    "view_work_method" => "Work method",
    "view_start_date" => "Start date",
    "view_end_date" => "End date",
    "view_created_at" => "Created on",
    "view_updated_at" => "Last updated on",
    "view_status" => "Status",
    "view_ministry" => "Ministry",
    "view_project_code" => "Project code",
    "view_budget" => "Budget",
    "view_actions" => "Actions",
    "view_subscribe" => "Follow",
    "view_subscribed" => "You are now following this project",
    "view_unsubscribe" => "Unfollow",
    "view_unsubscribed" => "You have stopped following this project",
    "view_tags" => "Tags",
    "view_no_tags" => "No tags have been associated with this project yet.",

    //
    // Create project
    //

    "create_title" => "Start project",
    "create_back" => "Back to overview",
    "create_submit" => "Start project",

    //
    // Update project
    //

    "update_title" => "Update project",
    "update_back" => "Go back to project",
    "update_submit" => "Save changes",

    //
    // Create & update project form
    //

    "form_optional" => "Optional",

    "form_general_title" => "General information",
    "form_general_description" => "Try to describe your project the best you can.",
    "form_status_title" => "Current state",
    "form_status_description" => "What's the current state of the project?",
    "form_ownership_title" => "Ownership",
    "form_ownership_description" => "What entities own this project?",
    "form_formatting_title" => "Formatting",
    "form_formatting_description" => "Make your project stand out",

    "form_title" => "Title",
    "form_title_hint" => "Name your project",
    "form_slogan" => "Slogan",
    "form_slogan_hint" => "Describe your project in one sentence, make it catchy.",
    "form_description" => "Description",
    "form_description_hint" => "What does the project exactly involve? Try to be as precise but short as possible.",
    "form_header_image" => "Header image",
    "form_roles" => "Team roles",
    "form_resources" => "Resources",
    "form_category" => "Category",
    "form_work_method" => "Work method",
    "form_status" => "Status",
    "form_has_tasks" => "Has tasks",
    "form_has_deadline" => "Has a deadline",
    "form_start_date" => "Start date",
    "form_deadline" => "Deadline",
    "form_has_budget" => "Has a budget",
    "form_budget" => "Budget",
    "form_ministry" => "Ministry",
    "form_organization" => "Organization",
    "form_department" => "Department",
    "form_project_code" => "Project code",
    "form_project_phase" => "Project phase",
    "form_tags" => "Tags",
    "form_optional" => "Optional",

    //
    // Delete project
    //

    "delete_title" => "Delete project",
    "delete_text" => "Are you sure you want to delete this (:title) project?\nAll data will be permanently deleted from the database.",
    "delete_cancel" => "No, <span class='extra-text'>go back</span>",
    "delete_confirm" => "Yes, <span class='extra-text'>delete</span>",

    //
    // View team
    //

    "view_team_outstanding_roles" => "Outstanding roles",
    "view_team_outstanding_roles_intro" => "The roles you see below are still available lorem ipsum dolor sit emet en dan nog wat latijnse woorden.",
    "view_team_assign_to_me" => "Assign to yourself",
    "view_team_assigned_to_self" => "The :name role has been assigned to yourself",
    "view_team_role_edit" => "Edit role",
    "view_team_role_delete" => "Delete role",
    "view_team_apply" => "Sign me up!",
    "view_team_no_roles" => "There are no outstanding roles at this moment",
    "view_team_team_members" => "Team members",
    "view_team_no_team_members" => "Be the first to join this team!",
    "view_team_add_roles" => "Add role",
    "view_team_leave" => "Leave team",
    "view_team_change_roles" => "Change user's roles",
    "view_team_remove_member" => "Remove user from team",

    //
    // Remove from team
    //

    "remove_from_team_title" => "Remove team member",
    "remove_from_team_text" => "Are you sure you want to remove :name from the team?",
    "remove_from_team_cancel" => "No, go back",
    "remove_from_team_submit" => "Yes, remove from team",
    "removed_from_team" => ":name has been removed from the team",

    //
    // Leave team
    //

    "leave_team_title" => "Leave team",
    "leave_team_text" => "Are you sure you want to leave this team?",
    "leave_team_back" => "No, go back",
    "leave_team_submit" => "Yes, leave team",
    "leave_team_success" => "Succesfully left the team",

    //
    // Apply to team
    //

    "apply_title" => "Apply for project",
    "apply_back" => "Back to project",
    "apply_submit" => "Submit your application!",
    "apply_form_project" => "Project",
    "apply_form_role" => "Roles you're interested in",
    "apply_form_motivation" => "Motivation",
    "apply_thanks" => "Thank you for your interest, the project owner will review your application.",

    //
    // Change roles of team member
    //

    "change_roles_title" => "Update member's roles",
    "change_roles_project" => "Project",
    "change_roles_user" => "Team member",
    "change_roles_role" => "Role",
    "change_roles_select_role" => "Select the role to assign to the user",
    "change_roles_no_roles_available" => "No roles available to assign to this user",
    "change_roles_success" => "Succesfully saved changes to user's roles.",

    //
    // View applications
    //

    "view_applications_my_title" => "My applications",
    "view_applications_my_empty" => "You have not applied for this project.",
    "view_applications_manage_title" => "Team applications",
    "view_applications_manage_empty" => "No applications have been received yet.",

    //
    // View application
    //

    "view_application_title" => "Application",

    //
    // Edit application
    //

    "edit_application_title" => "Update application",
    "edit_application_role" => "Team role",
    "edit_application_motivation" => "Motivation",

    //
    // Delete application
    //

    "delete_application_title" => "Delete application",
    "delete_application_text" => "Are you sure you want to delete this application?\nAll data will be permanently deleted from the database.",
    "delete_application_success" => "The application has been succesfully deleted.",

    //
    // Manage applications
    //

    "application_accepted" => "The application has been accepted",
    "application_rejected" => "The application has been rejected",
    "application_reopened" => "The application has been reopened",

    //    
    // Create role    
    //    

    "create_role_title" => "Add role",
    "create_role_name" => "Name",
    "create_role_description" => "Description",
    "create_role_positions" => "Number of positions",
    "create_role_back" => "Go back",
    "create_role_submit" => "Save changes",
    "create_role_succeeded" => "Role has been added to the team",

    //
    // Edit role
    // 

    "edit_role_title" => "Update role",
    "edit_role_name" => "Name",
    "edit_role_description" => "Description",
    "edit_role_positions" => "Number of positions",
    "edit_role_back" => "Go back",
    "edit_role_submit" => "Save changes",

    // 
    // Delete role
    // 

    "delete_role_title" => "Delete role",
    "delete_role_text" => "Are you sure you want to delete this role (:name)?\nAll data will be deleted and any associated user will be removed from the team.",
    "delete_role_succeeded" => "Role has been removed",

    //
    // Tasks overview
    //

    "tasks_overview_title" => "Tasks",
    "tasks_overview_create" => "Add task",
    "tasks_overview_open" => "Open tasks",
    "tasks_overview_open_empty" => "There are no open tasks at the moment",
    "tasks_overview_in_progress" => "Tasks in progress",
    "tasks_overview_in_progress_empty" => "There are no tasks currently in progress",
    "tasks_overview_completed" => "Tasks completed",
    "tasks_overview_completed_empty" => "There are no completed tasks yet",
    "tasks_overview_title" => "Title",
    "tasks_overview_category" => "Category",
    "tasks_overview_complexity" => "Complexity",

    //
    // Resources form field (create/update project)
    //

    "resources_field_no_resources" => "No resources have been added yet.",
    "resources_field_add_button" => "Add resource",
    "resources_field_form_title" => "Title",
    "resources_field_form_description" => "Description",
    "resources_field_form_file" => "File",
    "resources_field_create_dialog_title" => "Add resource",
    "resources_field_create_dialog_cancel" => "Cancel",
    "resources_field_create_dialog_submit" => "Save resource",
    "resources_field_update_dialog_title" => "Update resource",
    "resources_field_update_dialog_cancel" => "Cancel",
    "resources_field_update_dialog_submit" => "Save changes",
    "resources_field_delete_dialog_title" => "Delete resource",
    "resources_field_delete_dialog_text" => "Are you sure you want to delete this resource?",
    "resources_field_delete_dialog_cancel" => "No, cancel",
    "resources_field_delete_dialog_submit" => "Yes, delete resource",

];