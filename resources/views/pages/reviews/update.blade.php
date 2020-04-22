@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("reviews.update", $review) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::reviews.update_title")</h1>

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Form -->
            <form action="{{ route('reviews.update.post', $review->uuid) }}" method="post">
                @csrf

                <!-- Review form -->
                <review-form
                    :review="{{ $review->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    :strings="{{ $strings->toJson() }}"
                    back-href="{{ route('reviews.view', $review->uuid) }}">
                </review-form>

            </form>

        </div>
    </div>
@stop
