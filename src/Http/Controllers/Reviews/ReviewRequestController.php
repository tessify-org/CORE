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