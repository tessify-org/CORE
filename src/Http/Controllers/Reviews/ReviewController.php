<?php

namespace Tessify\Core\Http\Controllers\Reviews;

use Reviews;
use ReviewRequests;
use Tessify\Core\Http\Requests\Reviews\CreateReviewRequest;
use Tessify\Core\Http\Requests\Reviews\UpdateReviewRequest;
use Tessify\Core\Http\Requests\Reviews\DeleteReviewRequest;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function getOverview()
    {
        return view("tessify-core::pages.reviews.overview", [
            "reviews" => Reviews::getMyReviews(),
            "requests" => ReviewRequests::getMyRequests(),
            "outstandingStrings" => collect([
                "title" => __("tessify-core::reviews.overview_requests_title"),
                "no_records" => __("tessify-core::reviews.overview_requests_no_records"),
                "accept" => __("tessify-core::reviews.overview_requests_accept"),
                "reject" => __("tessify-core::reviews.overview_requests_reject"),
            ]),
            "overviewStrings" => collect([
                "title" => __("tessify-core::reviews.overview_list_title"),
                "no_records" => __("tessify-core::reviews.overview_no_records"),
            ])
        ]);
    }

    public function getView($uuid)
    {
        $review = Reviews::findByUuid($uuid);
        if (!$review)
        {
            flash(__("tessify-core::reviews.not_found"))->error();
            return redirect()->back();
        }

        return view("tessify-core::pages.reviews.view", [
            "review" => $review,
        ]);
    }

    public function getCreate($type, $slug)
    {
        return view("tessify-core::pages.reviews.create", [
            "type" => $type,
            "slug" => $slug,
            "oldInput" => collect([
                "rating" => old("rating"),
                "message" => old("message"),
            ])
        ]);
    }

    public function postCreate(CreateReviewRequest $request, $type, $slug)
    {
        
    }

    public function getUpdate($uuid)
    {
        $review = Reviews::findByUuid($uuid);
        if (!$review)
        {
            flash(__("tessify-core::reviews.not_found"))->error();
            return redirect()->back();
        }

        return view("tessify-core::pages.reviews.update", [
            "review" => $review,
            "oldInput" => collect([
                "rating" => old("rating"),
                "message" => old("message"),
            ])
        ]);
    }

    public function postUpdate(UpdateReviewRequest $request, $uuid)
    {
        $review = Reviews::findByUuid($uuid);
        if (!$review)
        {
            flash(__("tessify-core::reviews.not_found"))->error();
            return redirect()->back();
        }

    }

    public function getDelete($uuid)
    {
        $review = Reviews::findByUuid($uuid);
        if (!$review)
        {
            flash(__("tessify-core::reviews.not_found"))->error();
            return redirect()->back();
        }

        return view("tessify-core::pages.reviews.delete", [
            "review" => $review,
        ]);
    }

    public function postDelete(DeleteReviewRequest $request, $uuid)
    {
        $review = Reviews::findByUuid($uuid);
        if (!$review)
        {
            flash(__("tessify-core::reviews.not_found"))->error();
            return redirect()->back();
        }

        $review->delete();

        flash(__("tessify-core::reviews.deleted"))->success();
        return redirect()->route("");
    }
}