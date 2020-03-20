<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Tessify\Core\Models\BugReport;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\BugReports\SubmitBugReportRequest;

class BugReportService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\BugReport";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function createFromRequest(SubmitBugReportRequest $request)
    {
        return BugReport::create([
            "user_id" => Auth::check() ? Auth::user()->id : null,
            "url" => $request->url,
            "severity" => $request->severity,
            "report" => $request->report,
        ]);
    }
}