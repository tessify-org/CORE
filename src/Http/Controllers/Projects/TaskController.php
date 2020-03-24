<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Auth;
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
use Tessify\Core\Events\Tasks\TaskCreated;
use Tessify\Core\Events\Tasks\TaskAssigned;
use Tessify\Core\Events\Tasks\TaskCompleted;
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
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }
        
        return view("tessify-core::pages.tasks.view", [
            "task" => $task,
        ]);
    }
    
    public function getCreate($slug = null)
    {
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

        return view("tessify-core::pages.tasks.create", [
            "project" => $project,
            "projects" => Projects::getAllForUser(),
            "skills" => Skills::getAll(),
            "categories" => TaskCategories::getAll(),
            "seniorities" => TaskSeniorities::getAll(),
            "oldInput" => collect([
                "project_id" => old("project_id"),
                "task_seniority_id" => old("task_seniority_id"),
                "task_category_id" => old("task_category_id"),
                "title" => old("title"),
                "description" => old("description"),
                "complexity" => old("complexity"),
                "estimated_hours" => old("estimated_hours"),
                "required_skills" => old("required_skills"),
                "urgency" => old("urgency"),
            ]),
        ]);
    }

    public function postCreate(CreateTaskRequest $request)
    {
        $task = Tasks::createFromRequest($request);

        event(new TaskCreated($task));

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
            "oldInput" => collect([
                "project_id" => old("project_id"),
                "task_status_id" => old("task_status_id"),
                "task_seniority_id" => old("task_seniority_id"),
                "task_category_id" => old("task_category_id"),
                "title" => old("title"),
                "description" => old("description"),
                "complexity" => old("complexity"),
                "estimated_hours" => old("estimated_hours"),
                "realized_hours" => old("realized_hours"),
                "required_skills" => old("required_skills"),
                "urgency" => old("urgency"),
            ])
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

        flash(__("tessify-core::projects.tasks_updated"))->success();
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
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        Auth::user()->subscribe($task);

        flash(__("tessify-core::tasks.view_subscribed"))->success();
        return redirect()->route("tasks.view", ["slug" => $task->slug]);
    }

    public function getUnsubscribe($slug)
    {
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        Auth::user()->unsubscribe($task);

        flash(__("tessify-core::tasks.view_unsubscribed"))->success();
        return redirect()->route("tasks.view", ["slug" => $task->slug]);
    }

    public function getReportProgress($slug)
    {
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

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
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        $report = TaskProgressReports::createFromRequest($task, $request);

        event(new TaskProgressReported($task));

        flash(__("tessify-core::tasks.report_progress_success"))->success();
        return redirect()->route("tasks.progress-report", ["slug" => $task->slug, "uuid" => $report->uuid]);
    }

    public function getProgressReport($slug, $uuid)
    {
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        $report = TaskProgressReports::findPreloadedByUuid($uuid);
        if (!$report)
        {
            flash(__("tessify-core::projects.progress_report_not_found"))->error();
            return redirect()->route("tasks.view", ["slug" => $slug]);
        }

        if ($task->is_assigned)
        {
            TaskProgressReports::markReviewsAsRead($report);
        }

        return view("tessify-core::pages.tasks.progress-report", [
            "task" => $task,
            "report" => $report,
        ]);
    }

    public function getReviewProgressReport($slug, $uuid)
    {
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        $report = TaskProgressReports::findByUuid($uuid);
        if (!$report)
        {
            flash(__("tessify-core::projects.progress_report_not_found"))->error();
            return redirect()->route("tasks.view", ["slug" => $slug]);
        }

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
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        $report = TaskProgressReports::findByUuid($uuid);
        if (!$report)
        {
            flash(__("tessify-core::projects.progress_report_not_found"))->error();
            return redirect()->route("tasks.view", ["slug" => $slug]);
        }

        $review = TaskProgressReportReviews::createFromRequest($report, $request);

        flash(__("tessify-core::tasks.reviewed_progress_report"))->success();
        return redirect()->route("tasks.progress-report", ["slug" => $slug, "uuid" => $report->uuid]);
    }

    public function getComplete($slug)
    {
        $task = Tasks::findBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }
        
        Tasks::markAsCompleted($task);

        event(new TaskCompleted($task));

        flash(__("tessify-core::tasks.completed"))->success();
        return redirect()->route("tasks.view", ["slug" => $task->slug]);
    }
}