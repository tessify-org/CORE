<?php

namespace Tessify\Core\Http\Controllers\Reviews;

use ReviewRequests;
use App\Http\Controllers\Controller;

class ReviewRequestController extends Controller
{
    public function getAccept($uuid)
    {
        // Grab the review we want to accept
        $reviewRequest = ReviewRequests::findByUuid($uuid);
        if (!$reviewRequest)
        {
            flash(__("tessify-core::reviews.request_not_found"))->error();
            return redirect()->route("reviews");
        }

        // Redirect the user to the write review page where they can fulfill their ... acceptment?
        switch ($reviewRequest->reviewrequestable_type)
        {
            case "App\\Models\\User":
                return redirect()->route("reviews.create", ["type" => "user", "slug" => $reviewRequest->reviewrequestable->slug]);
            break;

            case "Tessify\\Core\\Models\\Task":
                return redirect()->route("reviews.create", ["type" => "task", "slug" => $reviewRequest->reviewrequestable->slug]);
            break;

            case "Tessify\\Core\\Models\\Project":
                return redirect()->route("reviews.create", ["type" => "project", "slug" => $reviewRequest->reviewrequestable->slug]);
            break;
        }

        // If we did not recognize the type of request; tell the user we did not find the request at all (probably should change this)
        flash(__("tessify-core::reviews.request_not_found"))->error();
        return redirect()->route("reviews");
    }

    public function getReject($uuid)
    {
        // Grab the request we want to reject
        $reviewRequest = ReviewRequests::findByUuid($uuid);
        if (!$reviewRequest)
        {
            flash(__("tessify-core::reviews.request_not_found"))->error();
            return redirect()->route("reviews");
        }

        // Reject the request
        ReviewRequests::reject($reviewRequest);

        // Flash message & redirect to my review requests page
        flash(__("tessify-core::reviews.request_rejected"))->success();
        return redirect()->route("reviews");
    }
}