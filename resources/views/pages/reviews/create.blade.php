@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("reviews.create", $target, $slug) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::reviews.create_title")</h1>

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Form -->
            <form action="{{ route('reviews.create.post', ['type' => $type, 'slug' => $slug]) }}" method="post">
                @csrf

                <!-- Review form -->
                <review-form
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    :strings="{{ $strings->toJson() }}"
                    back-href="{{ route('reviews') }}">
                </review-form>

            </form>

        </div>
    </div>
@stop
