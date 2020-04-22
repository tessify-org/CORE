<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Auth;
use Tags;
use Tasks;
use Skills;
use Projects;
use Reputation;
use TaskStatuses;
use TaskCategories;
use TaskSeniorities;
use TaskProgressReports;
use TaskProgressReportReviews;

use App\Http\Controllers\Controller;

use Tessify\Core\Events\Users\UserFollowsTask;
use Tessify\Core\Events\Users\UserUnfollowsTask;
use Tessify\Core\Events\Tasks\TaskAssigned;
use Tessify\Core\Events\Tasks\TaskUnassigned;
use Tessify\Core\Events\Tasks\TaskProgressReported;

use Tessify\Core\Http\Requests\Tasks\CreateTaskRequest;
use Tessify\Core\Http\Requests\Tasks\UpdateTaskRequest;
use Tessify\Core\Http\Requests\Tasks\DeleteTaskRequest;
use Tessify\Core\Http\Requests\Tasks\AbandonTaskRequest;
use Tessify\Core\Http\Requests\Tasks\ReportProgressRequest;
use Tessify\Core\Http\Requests\Tasks\ReviewProgressReportRequest;

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
            "tags" => Tags::getAll(),
            "oldInput" => collect([
                "project_id" => old("project_id"),
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
            ]),
            "strings" => collect([
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
                "required_skills_strings" => [
                    "no_records" => __("tessify-core::tasks.required_skills_no_records"),
                    "add_button" => __("tessify-core::tasks.required_skills_add_button"),
                    "view_title" => __("tessify-core::tasks.required_skills_view_title"),
                    "view_required_mastery" => __("tessify-core::tasks.required_skills_view_required_mastery"),
                    "view_description" => __("tessify-core::tasks.required_skills_view_description"),
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
            "tags" => Tags::getAll(),
            "oldInput" => collect([
                "project_id" => old("project_id"),
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
            ]),
            "strings" => collect([
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
                "required_skills_strings" => [
                    "no_records" => __("tessify-core::tasks.required_skills_no_records"),
                    "add_button" => __("tessify-core::tasks.required_skills_add_button"),
                    "view_title" => __("tessify-core::tasks.required_skills_view_title"),
                    "view_required_mastery" => __("tessify-core::tasks.required_skills_view_required_mastery"),
                    "view_description" => __("tessify-core::tasks.required_skills_view_description"),
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

        return view("tessify-core::pages.tasks.unassign-from-self", [
            "task" => $task,
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

        $task = Tasks::unassignUser($task);
        
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

    public function getReportProgress($slug)
    {
        // Grab the task we want to report progress on
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Render the report progress page
        return view("tessify-core::pages.tasks.report-progress", [
            "task" => $task,
            "oldInput" => collect([
                "message" => old("message"),
                "completed" => old("completed"),
            ])
        ]);
    }

    public function postReportProgress(ReportProgressRequest $request, $slug)
    {
        // Grab the task we want to report progress on
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Create the progress report
        $report = TaskProgressReports::createFromRequest($task, $request);

        // Fire events
        event(new TaskProgressReported($task));

        // Flash message & redirect to the view progress report page
        flash(__("tessify-core::tasks.report_progress_success"))->success();
        return redirect()->route("tasks.progress-report", ["slug" => $task->slug, "uuid" => $report->uuid]);
    }

    public function getProgressReport($slug, $uuid)
    {
        // Grab the task to which the report belongs
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Grab the progress report
        $report = TaskProgressReports::findPreloadedByUuid($uuid);
        if (!$report)
        {
            flash(__("tessify-core::projects.progress_report_not_found"))->error();
            return redirect()->route("tasks.view", ["slug" => $slug]);
        }

        // If this task is assigned to the current user
        if ($task->is_assigned)
        {
            // Mark the reviews this progress report may contain as read
            TaskProgressReports::markReviewsAsRead($report);
        }

        // Render the view progress report page
        return view("tessify-core::pages.tasks.progress-report", [
            "task" => $task,
            "report" => $report,
        ]);
    }

    public function getReviewProgressReport($slug, $uuid)
    {
        // Grab the task the progress report we want to review belongs to
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Grab the progress report we want to review
        $report = TaskProgressReports::findByUuid($uuid);
        if (!$report)
        {
            flash(__("tessify-core::projects.progress_report_not_found"))->error();
            return redirect()->route("tasks.view", ["slug" => $slug]);
        }

        // Render the review progress report page
        return view("tessify-core::pages.tasks.review-progress-report", [
            "task" => $task,
            "report" => $report,
            "oldInput" => collect([
                "message" => old("message"),
                "completed" => old("completed"),
            ])
        ]);
    }

    public function postReviewProgressReport(ReviewProgressReportRequest $request, $slug, $uuid)
    {
        // Grab the task the progress report we want to review belongs to
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Grab the progress report we want to review
        $report = TaskProgressReports::findByUuid($uuid);
        if (!$report)
        {
            flash(__("tessify-core::projects.progress_report_not_found"))->error();
            return redirect()->route("tasks.view", ["slug" => $slug]);
        }

        // Create the progress report review
        $review = TaskProgressReportReviews::createFromRequest($report, $request);

        // Flash message & redirect to the view progress report page
        flash(__("tessify-core::tasks.reviewed_progress_report"))->success();
        return redirect()->route("tasks.progress-report", ["slug" => $slug, "uuid" => $report->uuid]);
    }

    public function getComplete($slug)
    {
        // Grab the task we want to complete
        $task = Tasks::findBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Complete the task
        Tasks::complete($task);

        // Flash message & redirect to the view task page
        flash(__("tessify-core::tasks.completed"))->success();
        return redirect()->route("tasks.view", ["slug" => $task->slug]);
    }
}