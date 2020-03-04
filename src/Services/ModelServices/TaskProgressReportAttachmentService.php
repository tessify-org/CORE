<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\TaskProgressReport;
use Tessify\Core\Models\TaskProgressReportAttachment;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class TaskProgressReportAttachmentService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\TaskProgressReportAttachment";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function getAllForReport(TaskProgressReport $report)
    {
        $out = [];

        foreach ($this->getAll() as $attachment)
        {
            if ($attachment->task_progress_report_id == $report->id)
            {
                $out[] = $attachment;
            }
        }

        return $out;
    }
}