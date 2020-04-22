@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("reviews.view", $review) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::reviews.view_title")</h1>

            <!-- Review -->
            <div id="review-wrapper">

                <!-- Feedback -->
                @include("tessify-core::partials.feedback")

                <!-- Review -->
                <div id="review" class="elevation-1">

                    <!-- Target -->
                    <div id="review-target">
                        <div id="review-target__image" style="background-image: url({{ $target['image_url'] }});"></div>
                        <div id="review-target__text">
                            <div id="review-target__type">{{ $target['type'] }}</div>
                            <div id="review-target__name">{{ $target['name'] }}</div>
                        </div>
                    </div>
                    
                    <!-- Rating -->
                    <div id="review-rating">
                        <div id="review-rating__label">@lang("tessify-core::reviews.view_rating")</div>
                        <div id="review-rating__value">{{ $review->rating."/10" }}</div>
                    </div>
                    
                    <!-- Message -->
                    <div id="review-message">
                        <div id="review-message__label">@lang("tessify-core::reviews.view_message")</div>
                        <div id="review-message__value">{!! nl2br($review->message) !!}</div>
                    </div>

                </div>

                <!-- Controls -->
                <div class="page-controls">
                    <div class="page-controls__left">
                        
                        <!-- Back -->
                        <v-btn text href="{{ route('reviews') }}">
                            <i class="fas fa-arrow-left"></i>
                            @lang("tessify-core::reviews.view_back")
                        </v-btn>

                    </div>
                    <div class="page-controls__right">

                        <!-- Edit -->
                        <v-btn text color="warning" href="{{ route('reviews.update', $review->uuid) }}">
                            <i class="fas fa-edit"></i>
                            @lang("tessify-core::reviews.view_update")
                        </v-btn>

                        <!-- Delete -->
                        <v-btn text color="red" href="{{ route('reviews.delete', $review->uuid) }}">
                            <i class="fas fa-trash-alt"></i>
                            @lang("tessify-core::reviews.view_delete")
                        </v-btn>

                    </div>
                </div>

            </div>

        </div>
    </div>
@stop
