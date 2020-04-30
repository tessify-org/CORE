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

    'project_created' => 'Project is opgestart!.',
    'project_deleted' => 'Project is verwijderd!',
    'project_not_found' => 'Project kon niet worden gevonden.',
    'project_navigation_tasks' => 'Taken',

    'team_role_not_found' => 'Team rol kon niet worden gevonden.',
    'team_role_created' => 'Team rol is toegevoegd aan het project.',
    'team_role_updated' => 'Team rol is met success aangepast.',
    'team_role_deleted' => 'Team rol is met success verwijderd.',
    
    'project_navigation_info' => 'Project informatie',
    'project_navigation_team' => 'Het Team',
    'project_navigation_applications' => 'Aanmeldingen',

    'team_member_not_found' => 'Team lid kon niet worden gevonden',

    'task_not_found' => 'Taak kon niet worden gevonden',

    'progress_report_not_found' => 'Progressie rapport kon niet worden gevonden',
    
    //
    // Overview
    //

    "overview_title" => "Projecten",
    "overview_subtitle" => "Er zijn al :num_projects projecten geregistreerd!",
    "overview_create_cta" => "Zelf project starten!",
    "overview_description" => "Beschrijving",
    "overview_view" => "Bekijk project",
    "overview_no_projects" => "Geen projecten gevonden",

    "overview_sidebar_search" => "Zoeken",
    "overview_sidebar_statuses" => "Status",
    "overview_sidebar_statuses_hint" => "Geeft de huidige staat van het project aan",
    "overview_sidebar_statuses_empty" => "Geen statusen",
    "overview_sidebar_categories" => "Categorie",
    "overview_sidebar_categories_hint" => "Geeft aan wat voor type project je kunt verwachten",
    "overview_sidebar_categories_empty" => "Geen categorieën",

    "overview_table_title" => "Titel",
    "overview_table_status" => "Status",
    "overview_empty" => "Wees de eerste die een project toevoegd aan het platform!",
    "overview_create_button" => "Start project",
    
    // 
    // View project
    // 

    "view_description" => "Projectomschrijving",
    "view_owner" => "Eigenaar",
    "view_details" => "Details",
    "view_resources" => "Bijlagen",
    "view_no_resources" => "Er zijn nog geen bijlagen aan dit project toegevoegd",
    "view_category" => "Categorie",
    "view_work_method" => "Werk methode",
    "view_start_date" => "Start datum",
    "view_end_date" => "Eind datum",
    "view_created_at" => "Toegevoegd op",
    "view_updated_at" => "Laatst geupdate op",
    "view_status" => "Status",
    "view_ministry" => "Ministerie",
    "view_project_code" => "Project code",
    "view_budget" => "Budget",
    "view_actions" => "Acties",
    "view_subscribe" => "Volgen",
    "view_subscribed" => "Je volgt nu dit project",
    "view_unsubscribe" => "Stop met volgen",
    "view_unsubscribed" => "Je bent gestopt met het volgen van dit project",
    "view_tags" => "Tags",
    "view_no_tags" => "Er zijn nog geen tags geassocieerd met dit project",
    
    //
    // Create project
    //

    "create_title" => "Project starten",
    "create_back" => "Terug naar overzicht",
    "create_submit" => "Start project",

    //
    // Update project
    //

    "update_title" => "Project wijzigen",
    "update_back" => "Terug naar project",
    "update_submit" => "Wijzigingen opslaan",

    //
    // Create & update project form
    //

    "form_optional" => "Optioneel",

    "form_general_title" => "Algemene informatie",
    "form_general_description" => "Beschrijf je project zo duidelijk mogelijk.",
    "form_status_title" => "Huidige staat",
    "form_status_description" => "In welke staat bevindt het project zich?",
    "form_ownership_title" => "Eigenaarschap",
    "form_ownership_description" => "Welke entiteiten zijn eigenaar van dit project?",
    "form_formatting_title" => "Opmaak",
    "form_formatting_description" => "Make your project stand out",

    "form_title" => "Titel",
    "form_title_hint" => "Geef je project een naam!",
    "form_slogan" => "Kopregel",
    "form_slogan_hint" => "Omschrijf het project in 1 zin",
    "form_description" => "Projectomschrijving",
    "form_description_hint" => "1. Project omschrijving inclusief doel\n2. Wat is het product dat je wil toetsen?\n3. Wat gaat je helpen?\n4. Wie is de doelgroep/ontvange?\n5. Hoe de verbeteringen te meten?",
    "form_header_image" => "Header plaatje",
    "form_roles" => "Team rollen",
    "form_resources" => "Hulpmiddelen",
    "form_category" => "Categorie",
    "form_work_method" => "Werkmethode",
    "form_status" => "Status",
    "form_has_tasks" => "Heeft taken",
    "form_has_deadline" => "Heeft een deadline",
    "form_start_date" => "Start datum",
    "form_deadline" => "Deadline",
    "form_has_budget" => "Heeft een budget",
    "form_budget" => "Budget",
    "form_ministry" => "Ministerie",
    "form_organization" => "Organisatie",
    "form_department" => "Departement",
    "form_project_code" => "Project code",
    "form_project_phase" => "Project fase",
    "form_tags" => "Tags",
    "form_optional" => "Optioneel",

    //
    // Delete project
    //

    "delete_title" => "Project verwijderen",
    "delete_text" => "Weet je zeker dat je dit project (:title) wilt verwijderen?\nAlle data zal onomkeerbaar uit de database worden verwijderd.",
    "delete_cancel" => "Nee, <span class='extra-text'>terug</span>",
    "delete_confirm" => "Ja, <span class='extra-text'>verwijderen</span>",
    
    //
    // View team
    //

    "view_team_outstanding_roles" => "Openstaande team rollen",
    "view_team_outstanding_roles_intro" => "De rollen hieronder zijn nog beschikbaar en zou jij in kunnen vullen! Lorem ipsum bladiebla.",
    "view_team_assign_to_me" => "Aan jezelf toewijzen",
    "view_team_assigned_to_self" => "De :name rol is aan jezelf toegewezen",
    "view_team_role_edit" => "Rol aanpassen",
    "view_team_role_delete" => "Rol verwijderen",
    "view_team_apply" => "Ik wil mij aanmelden!",
    "view_team_no_roles" => "Er zijn momenteel geen openstaande rollen",
    "view_team_team_members" => "Teamleden",
    "view_team_no_team_members" => "Wees de eerste die zich bij dit team voegt!",
    "view_team_add_roles" => "Rol toevoegen",
    "view_team_leave" => "Team verlaten",
    "view_team_change_roles" => "Verander de rol van gebruiker",
    "view_team_remove_member" => "Verwijder uit het team",

    //
    // Remove from team
    //

    "remove_from_team_title" => "Teamlid verwijderen",
    "remove_from_team_text" => "Weet je zeker dat je :name uit het team wilt verwijderen?",
    "remove_from_team_cancel" => "Nee, ga terug",
    "remove_from_team_submit" => "Ja, verwijder uit team",
    "removed_from_team" => ":name is uit het team verwijderd",

    //
    // Leave team
    //

    "leave_team_title" => "Team verlaten",
    "leave_team_text" => "Weet je zeker dat je dit team wilt verlaten?",
    "leave_team_back" => "Nee, terug",
    "leave_team_submit" => "Ja, verlaat team",
    "leave_team_success" => "Je hebt het team verlaten",
    
    //
    // Apply to team
    //

    "apply_title" => "Aanmelden voor project",
    "apply_back" => "Terug naar project",
    "apply_submit" => "Verstuur je aanmelding!",
    "apply_form_project" => "Project",
    "apply_form_role" => "Rollen waar je interesse in hebt",
    "apply_form_motivation" => "Motivatie",
    "apply_thanks" => "Bedankt voor je aanmelding! De projecteigenaar zal hem binnenkort verwerken.",

    //
    // Change roles of team member
    //

    "change_roles_title" => "Update rollen van teamlid",
    "change_roles_project" => "Project",
    "change_roles_user" => "Team lid",
    "change_roles_role" => "Rol",
    "change_roles_select_role" => "Selecteer de rol om toe te wijzen aan de gebruiker",
    "change_roles_no_roles_available" => "Geen rollen beschikbaar om toe te wijzen aan de gebruiker",
    "change_roles_success" => "De rol van het teamlid is aangepast",
    
    //
    // View applications
    //

    "view_applications_my_title" => "Mijn aanmeldingen",
    "view_applications_my_empty" => "Je hebt je niet aangemeld voor dit project.",
    "view_applications_manage_title" => "Aanmeldingen voor het team",
    "view_applications_manage_empty" => "Er zijn nog geen aanmeldingen binnen gekomen.",

    //
    // View application
    //

    "view_application_title" => "Aanmelding",

    //
    // Edit application
    //

    "edit_application_title" => "Aanmelding aanpassen",
    "edit_application_role" => "Team rol",
    "edit_application_motivation" => "Motivatie",

    //
    // Delete application
    //

    "delete_application_title" => "Aanmelding verwijderen",
    "delete_application_text" => "Weet je zeker dat je je aanmelding wilt intrekken?\nAlle data wordt dan uit de database verwijderd.",
    "delete_application_success" => "De aanmelding is met success verwijderd.",

    //
    // Manage applications
    //

    "application_accepted" => "De aanmelding is geaccepteerd",
    "application_rejected" => "De aanmelding is afgewezen",
    "application_reopened" => "De aanmelding is opnieuw geopend",

    //    
    // Create role    
    //    

    "create_role_title" => "Rol toevoegen",
    "create_role_name" => "Naam",
    "create_role_description" => "Beschrijving",
    "create_role_positions" => "Aantal posities",
    "create_role_back" => "Ga terug",
    "create_role_submit" => "Opslaan",
    "create_role_succeeded" => "Rol is toegevoegd aan het team",

    //
    // Edit role
    // 

    "edit_role_title" => "Rol aanpassen",
    "edit_role_name" => "Naam",
    "edit_role_description" => "Beschrijving",
    "edit_role_positions" => "Aantal posities",
    "edit_role_back" => "Ga terug",
    "edit_role_submit" => "Opslaan",

    //
    // Delete role
    //

    "delete_role_title" => "Rol verwijderen",
    "delete_role_text" => "Weet je zeker dat je deze rol (:name) wilt verwijderen?\nAlle data wordt gewist en geassocieerde gebruikers worden uit het team verwijderd.",
    "delete_role_succeeded" => "Rol is verwijderd",

    //
    // Tasks overview
    //

    "tasks_overview_title" => "Werkpakketten",
    "tasks_overview_create" => "Werkpakket toevoegen",
    "tasks_overview_open" => "Openstaande taken",
    "tasks_overview_open_empty" => "Er zijn momenteel geen openstaande taken",
    "tasks_overview_in_progress" => "Taken in behandeling",
    "tasks_overview_in_progress_empty" => "Er zijn momenteel geen taken in behandeling",
    "tasks_overview_completed" => "Voltooide taken",
    "tasks_overview_completed_empty" => "Er zijn nog geen voltooide taken",
    "tasks_overview_title" => "Titel",
    "tasks_overview_category" => "Categorie",
    "tasks_overview_complexity" => "Complexiteit",

    //
    // Resources form field (create/update project)
    //

    "resources_field_no_resources" => "Er zijn nog geen hulpmiddelen toegevoegd.",
    "resources_field_add_button" => "Hulpmiddel toevoegen",
    "resources_field_form_title" => "Titel",
    "resources_field_form_description" => "Omschrijving",
    "resources_field_form_file" => "Bestand",
    "resources_field_create_dialog_title" => "Hulpmiddel toevoegen",
    "resources_field_create_dialog_cancel" => "Annuleren",
    "resources_field_create_dialog_submit" => "Hulpmiddel opslaan",
    "resources_field_update_dialog_title" => "Hulpmiddel aanpassen",
    "resources_field_update_dialog_cancel" => "Annuleren",
    "resources_field_update_dialog_submit" => "Wijzigingen opslaan",
    "resources_field_delete_dialog_title" => "Hulpmiddel verwijderen",
    "resources_field_delete_dialog_text" => "Weet je zeker dat je dit hulpmiddel wilt verwijderen?",
    "resources_field_delete_dialog_cancel" => "Nee, annuleren",
    "resources_field_delete_dialog_submit" => "Ja, verwijder hulpmiddel",

];