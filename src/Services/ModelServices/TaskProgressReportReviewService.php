<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Tessify\Core\Models\TaskProgressReport;
use Tessify\Core\Models\TaskProgressReportReview;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Projects\Tasks\ReviewProgressReportRequest;

class TaskProgressReportReviewService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\TaskProgressReportReview";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function getAllForReport(TaskProgressReport $report)
    {
        $out = [];

        foreach ($this->getAllPreloaded() as $review)
        {
            if ($review->task_progress_report_id == $report->id)
            {
                $out[] = $review;
            }
        }

        return $out;
    }

    public function createFromRequest(TaskProgressReport $report, ReviewProgressReportRequest $request)
    {
        return TaskProgressReportReview::create([
            "task_progress_report_id" => $report->id,
            "user_id" => Auth::user()->id,
            "message" => $request->message
        ]);
    }

    public function markAsRead(TaskProgressReportReview $review)
    {
        $review->read_by_assigned_user = true;
        $review->save();

        return $review;
    }
}