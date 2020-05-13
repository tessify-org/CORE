<?php

namespace Tessify\Core\Http\Controllers\Tasks;

use Auth;
use Tags;
use Users;
use Tasks;
use Skills;
use Comments;
use ReviewRequests;
use Projects;
use Messages;
use Reputation;
use Ministries;
use Organizations;
use OrganizationDepartments;
use TaskStatuses;
use TaskCategories;
use TaskSeniorities;
use TaskProgressReports;
use TaskProgressReportReviews;

use App\Http\Controllers\Controller;
use Tessify\Core\Events\Tasks\TaskAssigned;
use Tessify\Core\Events\Tasks\TaskUnassigned;
use Tessify\Core\Events\Users\UserFollowsTask;
use Tessify\Core\Events\Users\UserUnfollowsTask;
use Tessify\Core\Http\Requests\Tasks\CreateTaskRequest;
use Tessify\Core\Http\Requests\Tasks\UpdateTaskRequest;
use Tessify\Core\Http\Requests\Tasks\DeleteTaskRequest;
use Tessify\Core\Http\Requests\Tasks\AbandonTaskRequest;
use Tessify\Core\Http\Requests\Tasks\AskQuestionRequest;

class TaskController extends Controller
{
    public function getOverview()
    {
        // Render the task overview page
        return view("tessify-core::pages.tasks.overview", [
            "tasks" => Tasks::getAllPreloaded(),
            "skills" => Skills::getAll(),
            "statuses" => TaskStatuses::getAll(),
            "categories" => TaskCategories::getAll(),
            "seniorities" => TaskSeniorities::getAll(),
        ]);
    }

    public function getView($slug)
    {
        // Grab the task we want to view
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Render the view task page
        return view("tessify-core::pages.tasks.view", [
            "task" => $task,
            "users" => Users::getAllPreloaded(),
            "userHasPendingReviewRequest" => ReviewRequests::hasOutstandingRequestsFor($task),
            "inviteButtonStrings" => collect([
                "button" => __("tessify-core::tasks.view_invite_friend"),
                "dialog_title" => __("tessify-core::tasks.view_invite_friend_dialog_title"),
                "dialog_text" => __("tessify-core::tasks.view_invite_friend_dialog_text"),
                "dialog_form_user" => __("tessify-core::tasks.view_invite_friend_dialog_form_user"),
                "dialog_cancel" => __("tessify-core::tasks.view_invite_friend_dialog_cancel"),
                "dialog_submit" => __("tessify-core::tasks.view_invite_friend_dialog_submit")
            ]),
            "askQuestionStrings" => collect([
                "button" => __("tessify-core::tasks.view_ask_question"),
                "dialog_title" => __("tessify-core::tasks.view_ask_question_dialog_title"),
                "dialog_text" => __("tessify-core::tasks.view_ask_question_dialog_text"),
                "dialog_form_question" => __("tessify-core::tasks.view_ask_question_dialog_form_question"),
                "dialog_cancel" => __("tessify-core::tasks.view_ask_question_dialog_cancel"),
                "dialog_submit" => __("tessify-core::tasks.view_ask_question_dialog_submit"),
                "success_dialog_title" => __("tessify-core::tasks.view_ask_question_success_dialog_title"),
                "success_dialog_text" => __("tessify-core::tasks.view_ask_question_success_dialog_text"),
            ]),
        ]);
    }
    
    public function getComments($slug)
    {
        // Grab the task we want to view
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Render the task comments page
        return view("tessify-core::pages.tasks.comments", [
            "user" => Users::current(),
            "task" => $task,
            "comments" => Comments::getAllForTask($task),
            "strings" => collect([
                "title" => __("tessify-core::comments.title"),
                "no_records" => __("tessify-core::comments.no_comments_task"),
                "create_title" => __("tessify-core::comments.create_title"),
                "create_submit" => __("tessify-core::comments.create_submit"),
                "create_cancel" => __("tessify-core::comments.create_cancel"),
                "update_title" => __("tessify-core::comments.update_title"),
                "update_cancel" => __("tessify-core::comments.update_cancel"),
                "update_submit" => __("tessify-core::comments.update_submit"),
                "delete_title" => __("tessify-core::comments.delete_title"),
                "delete_text" => __("tessify-core::comments.delete_text"),
                "delete_cancel" => __("tessify-core::comments.delete_cancel"),
                "delete_submit" => __("tessify-core::comments.delete_submit"),
            ]),
            "apiEndpoints" => collect([
                "create" => route("api.comments.create.post"),
                "update" => route("api.comments.update.post"),
                "delete" => route("api.comments.delete.post"),
            ]),
        ]);
    }

    public function getCreate($slug = null)
    {
        // Grab the parent project if a slug was provided
        $project = null;
        if (!is_null($slug))
        {
            $project = Projects::findPreloadedBySlug($slug);
            if (!$project)
            {
                flash(__("tessify-core::projects.project_not_found"))->error();
                return redirect()->route("projects");
            }
        }

        // Render the create task page
        return view("tessify-core::pages.tasks.create", [
            "project" => $project,
            "projects" => Projects::getAllForUser(),
            "skills" => Skills::getAll(),
            "categories" => TaskCategories::getAll(),
            "seniorities" => TaskSeniorities::getAll(),
            "ministries" => Ministries::getAll(),
            "organizations" => Organizations::getAll(),
            "departments" => OrganizationDepartments::getAll(),
            "tags" => Tags::getAll(),
            "oldInput" => collect([
                "project_id" => old("project_id"),
                "ministry_id" => old("ministry_id"),
                "organization_id" => old("organization_id"),
                "department" => old("department"),
                "task_seniority_id" => old("task_seniority_id"),
                "task_category" => old("task_category"),
                "title" => old("title"),
                "description" => old("description"),
                "tags" => old("tags"),
                "complexity" => old("complexity"),
                "estimated_hours" => old("estimated_hours"),
                "required_skills" => old("required_skills"),
                "urgency" => old("urgency"),
                "tags" => old("tags"),
                "ends_at" => old("ends_at"),
                "has_deadline" => old("has_deadline"),
            ]),
            "strings" => collect([
                "general_title" => __("tessify-core::tasks.form_general_title"),
                "general_description" => __("tessify-core::tasks.form_general_description"),
                "ownership_title" => __("tessify-core::tasks.form_ownership_title"),
                "ownership_description" => __("tessify-core::tasks.form_ownership_description"),
                "formatting_title" => __("tessify-core::tasks.form_formatting_title"),
                "formatting_description" => __("tessify-core::tasks.form_formatting_description"),
                "skills_title" => __("tessify-core::tasks.form_skills_title"),
                "skills_description" => __("tessify-core::tasks.form_skills_description"),
                "header_image" => __("tessify-core::tasks.form_header_image"),
                "has_deadline" => __("tessify-core::tasks.form_has_deadline"),
                "ends_at" => __("tessify-core::tasks.form_ends_at"),
                "ministry" => __("tessify-core::tasks.form_ministry"),
                "organization" => __("tessify-core::tasks.form_organization"),
                "department" => __("tessify-core::tasks.form_department"),
                "status" => __("tessify-core::tasks.create_form_status"),
                "project" => __("tessify-core::tasks.create_form_project"),
                "category" => __("tessify-core::tasks.create_form_category"),
                "seniority" => __("tessify-core::tasks.create_form_seniority"),
                "title" => __("tessify-core::tasks.create_form_title"),
                "description" => __("tessify-core::tasks.create_form_description"),
                "complexity" => __("tessify-core::tasks.create_form_complexity"),
                "estimated_hours" => __("tessify-core::tasks.create_form_estimated_hours"),
                "realized_hours" => __("tessify-core::tasks.create_form_realized_hours"),
                "select_category" => __("tessify-core::tasks.create_form_select_category"),
                "no_categories" => __("tessify-core::tasks.create_form_no_categories"),
                "select_seniority" => __("tessify-core::tasks.create_form_select_seniority"),
                "no_seniorities" => __("tessify-core::tasks.create_form_no_seniorities"),
                "select_status" => __("tessify-core::tasks.create_form_select_status"),
                "no_statuses" => __("tessify-core::tasks.create_form_no_statuses"),
                "required_skills" => __("tessify-core::tasks.create_form_required_skills"),
                "urgency" => __("tessify-core::tasks.create_form_urgency"),
                "tags" => __("tessify-core::tasks.create_form_tags"),
                "back" => __("tessify-core::tasks.create_back"),
                "submit" => __("tessify-core::tasks.create_submit"),
                "urgency_low" => __("tessify-core::general.urgency_low"),
                "urgency_normal" => __("tessify-core::general.urgency_normal"),
                "urgency_high" => __("tessify-core::general.urgency_high"),
                "required_skills_strings" => [
                    "title" => __("tessify-core::tasks.required_skills_title"),
                    "no_records" => __("tessify-core::tasks.required_skills_no_records"),
                    "add_button" => __("tessify-core::tasks.required_skills_add_button"),
                    "view_title" => __("tessify-core::tasks.required_skills_view_title"),
                    "view_skill" => __("tessify-core::tasks.required_skills_view_skill"),
                    "view_required_mastery" => __("tessify-core::tasks.required_skills_view_required_mastery"),
                    "view_description" => __("tessify-core::tasks.required_skills_view_description"),
                    "view_edit" => __("tessify-core::tasks.required_skills_view_edit"),
                    "view_delete" => __("tessify-core::tasks.required_skills_view_delete"),
                    "form_skill" => __("tessify-core::tasks.required_skills_form_skill"),
                    "form_required_mastery" => __("tessify-core::tasks.required_skills_form_required_mastery"),
                    "form_description" => __("tessify-core::tasks.required_skills_form_description"),
                    "add_title" => __("tessify-core::tasks.required_skills_add_title"),
                    "add_cancel" => __("tessify-core::tasks.required_skills_add_cancel"),
                    "add_submit" => __("tessify-core::tasks.required_skills_add_submit"),
                    "edit_title" => __("tessify-core::tasks.required_skills_edit_title"),
                    "edit_cancel" => __("tessify-core::tasks.required_skills_edit_cancel"),
                    "edit_submit" => __("tessify-core::tasks.required_skills_edit_submit"),
                    "delete_title" => __("tessify-core::tasks.required_skills_delete_title"),
                    "delete_text" => __("tessify-core::tasks.required_skills_delete_text"),
                    "delete_cancel" => __("tessify-core::tasks.required_skills_delete_cancel"),
                    "delete_submit" => __("tessify-core::tasks.required_skills_delete_submit"),
                ]
            ]),
        ]);
    }

    public function postCreate(CreateTaskRequest $request)
    {
        // Create the task
        $task = Tasks::createFromRequest($request);

        // Flash message && redirect to view task page
        flash(__("tessify-core::tasks.created"))->success();
        return redirect()->route("tasks.view", ["slug" => $task->slug]);
    }

    public function getEdit($slug)
    {
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }
        
        return view("tessify-core::pages.tasks.edit", [
            "task" => $task,
            "projects" => Projects::getAllForUser(),
            "skills" => Skills::getAll(),
            "statuses" => TaskStatuses::getAll(),
            "categories" => TaskCategories::getAll(),
            "seniorities" => TaskSeniorities::getAll(),
            "ministries" => Ministries::getAll(),
            "organizations" => Organizations::getAll(),
            "departments" => OrganizationDepartments::getAll(),
            "tags" => Tags::getAll(),
            "oldInput" => collect([
                "project_id" => old("project_id"),
                "ministry_id" => old("ministry_id"),
                "organization_id" => old("organization_id"),
                "department" => old("department"),
                "task_status_id" => old("task_status_id"),
                "task_seniority_id" => old("task_seniority_id"),
                "task_category" => old("task_category"),
                "title" => old("title"),
                "description" => old("description"),
                "tags" => old("tags"),
                "complexity" => old("complexity"),
                "estimated_hours" => old("estimated_hours"),
                "realized_hours" => old("realized_hours"),
                "required_skills" => old("required_skills"),
                "urgency" => old("urgency"),
                "tags" => old("tags"),
                "ends_at" => old("ends_at"),
                "has_deadline" => old("has_deadline"),
            ]),
            "strings" => collect([
                "general_title" => __("tessify-core::tasks.form_general_title"),
                "general_description" => __("tessify-core::tasks.form_general_description"),
                "ownership_title" => __("tessify-core::tasks.form_ownership_title"),
                "ownership_description" => __("tessify-core::tasks.form_ownership_description"),
                "formatting_title" => __("tessify-core::tasks.form_formatting_title"),
                "formatting_description" => __("tessify-core::tasks.form_formatting_description"),
                "skills_title" => __("tessify-core::tasks.form_skills_title"),
                "skills_description" => __("tessify-core::tasks.form_skills_description"),
                "header_image" => __("tessify-core::tasks.form_header_image"),
                "has_deadline" => __("tessify-core::tasks.form_has_deadline"),
                "ends_at" => __("tessify-core::tasks.form_ends_at"),
                "ministry" => __("tessify-core::tasks.form_ministry"),
                "organization" => __("tessify-core::tasks.form_organization"),
                "department" => __("tessify-core::tasks.form_department"),
                "status" => __("tessify-core::tasks.create_form_status"),
                "project" => __("tessify-core::tasks.create_form_project"),
                "category" => __("tessify-core::tasks.create_form_category"),
                "seniority" => __("tessify-core::tasks.create_form_seniority"),
                "title" => __("tessify-core::tasks.create_form_title"),
                "description" => __("tessify-core::tasks.create_form_description"),
                "complexity" => __("tessify-core::tasks.create_form_complexity"),
                "estimated_hours" => __("tessify-core::tasks.create_form_estimated_hours"),
                "realized_hours" => __("tessify-core::tasks.create_form_realized_hours"),
                "select_category" => __("tessify-core::tasks.create_form_select_category"),
                "no_categories" => __("tessify-core::tasks.create_form_no_categories"),
                "select_seniority" => __("tessify-core::tasks.create_form_select_seniority"),
                "no_seniorities" => __("tessify-core::tasks.create_form_no_seniorities"),
                "select_status" => __("tessify-core::tasks.create_form_select_status"),
                "no_statuses" => __("tessify-core::tasks.create_form_no_statuses"),
                "required_skills" => __("tessify-core::tasks.create_form_required_skills"),
                "urgency" => __("tessify-core::tasks.create_form_urgency"),
                "tags" => __("tessify-core::tasks.create_form_tags"),
                "back" => __("tessify-core::tasks.create_back"),
                "submit" => __("tessify-core::tasks.create_submit"),
                "urgency_low" => __("tessify-core::general.urgency_low"),
                "urgency_normal" => __("tessify-core::general.urgency_normal"),
                "urgency_high" => __("tessify-core::general.urgency_high"),
                "required_skills_strings" => [
                    "title" => __("tessify-core::tasks.required_skills_title"),
                    "no_records" => __("tessify-core::tasks.required_skills_no_records"),
                    "add_button" => __("tessify-core::tasks.required_skills_add_button"),
                    "view_title" => __("tessify-core::tasks.required_skills_view_title"),
                    "view_skill" => __("tessify-core::tasks.required_skills_view_skill"),
                    "view_required_mastery" => __("tessify-core::tasks.required_skills_view_required_mastery"),
                    "view_description" => __("tessify-core::tasks.required_skills_view_description"),
                    "view_edit" => __("tessify-core::tasks.required_skills_view_edit"),
                    "view_delete" => __("tessify-core::tasks.required_skills_view_delete"),
                    "form_skill" => __("tessify-core::tasks.required_skills_form_skill"),
                    "form_required_mastery" => __("tessify-core::tasks.required_skills_form_required_mastery"),
                    "form_description" => __("tessify-core::tasks.required_skills_form_description"),
                    "add_title" => __("tessify-core::tasks.required_skills_add_title"),
                    "add_cancel" => __("tessify-core::tasks.required_skills_add_cancel"),
                    "add_submit" => __("tessify-core::tasks.required_skills_add_submit"),
                    "edit_title" => __("tessify-core::tasks.required_skills_edit_title"),
                    "edit_cancel" => __("tessify-core::tasks.required_skills_edit_cancel"),
                    "edit_submit" => __("tessify-core::tasks.required_skills_edit_submit"),
                    "delete_title" => __("tessify-core::tasks.required_skills_delete_title"),
                    "delete_text" => __("tessify-core::tasks.required_skills_delete_text"),
                    "delete_cancel" => __("tessify-core::tasks.required_skills_delete_cancel"),
                    "delete_submit" => __("tessify-core::tasks.required_skills_delete_submit"),
                ]
            ]),
        ]);
    }

    public function postEdit(UpdateTaskRequest $request, $slug)
    {
        $task = Tasks::findBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        Tasks::updateFromRequest($task, $request);

        flash(__("tessify-core::tasks.edited"))->success();
        return redirect()->route("tasks.view", ["slug" => $task->slug]);
    }

    public function getDelete($slug)
    {
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        return view("tessify-core::pages.tasks.delete", [
            "task" => $task,
        ]);
    }

    public function postDelete(DeleteTaskRequest $request, $slug)
    {
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        $project = $task->project;

        $task->delete();

        flash(__("tessify-core::projects.tasks_deleted"))->error();
        if ($project) {
            return redirect()->route("projects.tasks", $project->slug);
        } else {
            return redirect()->route("tasks");
        }
    }

    public function getAssignToSelf($slug)
    {
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        Tasks::assignToUser($task);

        event(new TaskAssigned($task));

        flash(__("tessify-core::tasks.assign_to_self_success"))->success();
        return redirect()->route("tasks.view", ["slug" => $task->slug]);
    }

    public function getAbandon($slug)
    {
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        return view("tessify-core::pages.tasks.abandon", [
            "task" => $task,
            "strings" => collect([
                "text" => __("tessify-core::tasks.abandon_text", ["title" => $task->title]),
                "reason" => __("tessify-core::tasks.abandon_reason"),
                "reason_placeholder" => __("tessify-core::tasks.abandon_reason_placeholder"),
                "cancel" => __("tessify-core::tasks.abandon_cancel"),
                "submit" => __("tessify-core::tasks.abandon_confirm"),
            ]),
            "oldInput" => collect([
                "reason" => old("reason"),
            ]),
        ]);
    }

    public function postAbandon(AbandonTaskRequest $request, $slug)
    {
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        $task = Tasks::unassignUser($task, $request->reason);
        
        event(new TaskUnassigned($task));

        flash(__("tessify-core::tasks.abandon_success"))->success();
        return redirect()->route("tasks.view", ["slug" => $task->slug]);
    }

    public function getSubscribe($slug)
    {
        // Grab the task we want to subscribe to
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Subscribe to the user to the task
        Auth::user()->subscribe($task);

        // Fire events
        event(new UserFollowsTask(auth()->user(), $task));

        // Flash message & redirect to the view task page
        flash(__("tessify-core::tasks.view_subscribed"))->success();
        return redirect()->route("tasks.view", ["slug" => $task->slug]);
    }

    public function getUnsubscribe($slug)
    {
        // Grab the task we want to unsubscribe from
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Unsubscribe the user from the task
        Auth::user()->unsubscribe($task);

        // Fire events
        event(new UserUnfollowsTask(auth()->user(), $task));

        // Flash message & redirect to the view page
        flash(__("tessify-core::tasks.view_unsubscribed"))->success();
        return redirect()->route("tasks.view", ["slug" => $task->slug]);
    }

    public function getInviteFriend($slug, $userSlug = null)
    {
        // Grab the task we want to complete
        $task = Tasks::findBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }
        
        // Make sure we received a target user
        if (is_null($userSlug))
        {
            flash(__("tessify-core::messages.invitation_failed"))->error();
            return redirect()->route("tasks.view", $task->slug);
        }

        // Grab the target user
        $user = Users::findBySlug($userSlug);
        if (!$user)
        {
            flash(__("tessify-core::messages.invitation_failed"))->error();
            return redirect()->route("tasks.view", $task->slug);
        }

        // Send invitation message
        Messages::sendInviteToTaskMessage($user, $task);

        // Flash message and redirect back to view task page
        flash(__("tessify-core::messages.invitation_sent"))->success();
        return redirect()->route("tasks.view", $task->slug);
    }

    public function postAskQuestion(AskQuestionRequest $request, $slug)
    {
        // Grab the task we want to complete
        $task = Tasks::findBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Grab currently logged in user
        $user = Users::current();

        // Send ask question message
        Messages::sendAskTaskQuestionMessage($user, $task, $request->question);

        // Flash message and redirect back to view task page
        return response()->json(["status" => "success"]);
    }
}