@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("reviews") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::reviews.overview_title")</h1>

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- My reviews -->
            <div id="my-reviews">

                <!-- Outstanding review requests -->
                <review-request-overview
                    :requests="{{ $requests->toJson() }}"
                    :strings="{{ $outstandingStrings->toJson() }}">
                </review-request-overview>

                <!-- Review overview -->
                <review-overview
                    :reviews="{{ $reviews->toJson() }}"
                    :strings="{{ $overviewStrings->toJson() }}">
                </review-overview>

            </div>

        </div>
    </div>
@stop
