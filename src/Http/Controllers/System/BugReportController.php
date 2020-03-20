<?php

namespace Tessify\Core\Http\Controllers\System;

use BugReports;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\BugReports\SubmitBugReportRequest;

class BugReportController extends Controller
{
    public function postSubmitReport(SubmitBugReportRequest $request)
    {
        $report = BugReports::createFromRequest($request);
        return view("tessify-core::pages.bug-reports.thank-you", ["report" => $report]);
    }
}