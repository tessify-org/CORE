<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Auth;
use Tasks;
use Skills;
use Projects;
use TaskStatuses;
use TaskCategories;
use TaskSeniorities;
use TaskProgressReports;
use TaskProgressReportReviews;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Projects\Tasks\CreateTaskRequest;
use Tessify\Core\Http\Requests\Projects\Tasks\UpdateTaskRequest;
use Tessify\Core\Http\Requests\Projects\Tasks\DeleteTaskRequest;
use Tessify\Core\Http\Requests\Projects\Tasks\AbandonTaskRequest;
use Tessify\Core\Http\Requests\Projects\Tasks\ReportProgressRequest;
use Tessify\Core\Http\Requests\Projects\Tasks\ReviewProgressReportRequest;

class TaskController extends Controller
{
    public function getOverview($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.tasks.overview", [
            "project" => $project,
            "tasks" => Tasks::getAllForProject($project),
        ]);
    }

    public function getView($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }
        
        return view("tessify-core::pages.projects.tasks.view", [
            "project" => $project,
            "task" => $task,
        ]);
    }
    
    public function getCreate($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.tasks.create", [
            "project" => $project,
            "skills" => Skills::getAll(),
            "categories" => TaskCategories::getAll(),
            "seniorities" => TaskSeniorities::getAll(),
            "oldInput" => collect([
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

    public function postCreate(CreateTaskRequest $request, $slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::createFromRequest($project, $request);

        flash(__("tessify-core::projects.tasks_created"))->success();
        return redirect()->route("projects.tasks.view", ["slug" => $slug, "taskSlug" => $task->slug]);
    }

    public function getEdit($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }
        
        return view("tessify-core::pages.projects.tasks.edit", [
            "task" => $task,
            "project" => $project,
            "skills" => Skills::getAll(),
            "statuses" => TaskStatuses::getAll(),
            "categories" => TaskCategories::getAll(),
            "seniorities" => TaskSeniorities::getAll(),
            "oldInput" => collect([
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

    public function postEdit(UpdateTaskRequest $request, $slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        Tasks::updateFromRequest($task, $request);

        flash(__("tessify-core::projects.tasks_updated"))->success();
        return redirect()->route("projects.tasks.view", ["slug" => $project->slug, "taskSlug" => $task->slug]);
    }

    public function getDelete($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        return view("tessify-core::pages.projects.tasks.delete", [
            "project" => $project,
            "task" => $task,
        ]);
    }

    public function postDelete(DeleteTaskRequest $request, $slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        $task->delete();

        flash(__("tessify-core::projects.tasks_deleted"))->error();
        return redirect()->route("projects.tasks", $project->slug);
    }

    public function getAssignToSelf($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        Tasks::assignToUser($task);

        flash(__("tessify-core::tasks.assign_to_self_success"))->success();
        return redirect()->route("projects.tasks.view", ["slug" => $project->slug, "taskSlug" => $task->slug]);
    }

    public function getAbandon($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        return view("tessify-core::pages.projects.tasks.unassign-from-self", [
            "project" => $project,
            "task" => $task,
        ]);
    }

    public function postAbandon(AbandonTaskRequest $request, $slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        Tasks::unassignUser($task);

        flash(__("tessify-core::tasks.abandon_success"))->success();
        return redirect()->route("projects.tasks.view", ["slug" => $project->slug, "taskSlug" => $task->slug]);
    }

    public function getSubscribe($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        Auth::user()->subscribe($task);

        flash(__("tessify-core::tasks.view_subscribed"))->success();
        return redirect()->route("projects.tasks.view", ["slug" => $project->slug, "taskSlug" => $task->slug]);
    }

    public function getUnsubscribe($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        Auth::user()->unsubscribe($task);

        flash(__("tessify-core::tasks.view_unsubscribed"))->success();
        return redirect()->route("projects.tasks.view", ["slug" => $project->slug, "taskSlug" => $task->slug]);
    }

    public function getReportProgress($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        return view("tessify-core::pages.projects.tasks.report-progress", [
            "task" => $task,
            "project" => $project,
            "oldInput" => collect([
                "message" => old("message"),
                "completed" => old("completed"),
            ])
        ]);
    }

    public function postReportProgress(ReportProgressRequest $request, $slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        $report = TaskProgressReports::createFromRequest($task, $request);

        flash(__("tessify-core::tasks.report_progress_success"))->success();
        return redirect()->route("projects.tasks.progress-report", [
            "slug" => $project->slug, 
            "taskSlug" => $task->slug, 
            "uuid" => $report->uuid
        ]);
    }

    public function getProgressReport($slug, $taskSlug, $uuid)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        $report = TaskProgressReports::findPreloadedByUuid($uuid);
        if (!$report)
        {
            flash(__("tessify-core::projects.progress_report_not_found"))->error();
            return redirect()->route("projects.tasks.view", ["slug" => $slug, "taskSlug" => $taskSlug]);
        }

        if ($task->is_assigned)
        {
            TaskProgressReports::markReviewsAsRead($report);
        }

        return view("tessify-core::pages.projects.tasks.progress-report", [
            "task" => $task,
            "report" => $report,
            "project" => $project,
        ]);
    }

    public function getReviewProgressReport($slug, $taskSlug, $uuid)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        $report = TaskProgressReports::findByUuid($uuid);
        if (!$report)
        {
            flash(__("tessify-core::projects.progress_report_not_found"))->error();
            return redirect()->route("projects.tasks.view", ["slug" => $slug, "taskSlug" => $taskSlug]);
        }

        return view("tessify-core::pages.projects.tasks.review-progress-report", [
            "task" => $task,
            "report" => $report,
            "project" => $project,
            "oldInput" => collect([
                "message" => old("message"),
                "completed" => old("completed"),
            ])
        ]);
    }

    public function postReviewProgressReport(ReviewProgressReportRequest $request, $slug, $taskSlug, $uuid)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        $report = TaskProgressReports::findByUuid($uuid);
        if (!$report)
        {
            flash(__("tessify-core::projects.progress_report_not_found"))->error();
            return redirect()->route("projects.tasks.view", ["slug" => $slug, "taskSlug" => $taskSlug]);
        }

        $review = TaskProgressReportReviews::createFromRequest($report, $request);

        flash(__("tessify-core::tasks.reviewed_progress_report"))->success();
        return redirect()->route("projects.tasks.progress-report", ["slug" => $slug, "taskSlug" => $taskSlug, "uuid" => $report->uuid]);
    }

    public function getComplete($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }
        
        Tasks::markAsCompleted($task);

        flash(__("tessify-core::tasks.completed"))->success();
        return redirect()->route("projects.tasks.view", ["slug" => $project->slug, "taskSlug" => $task->slug]);
    }
}