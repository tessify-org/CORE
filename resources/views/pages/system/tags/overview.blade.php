@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tags") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::tags.overview_title")</h1>
        
            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Tags -->
            <div class="content-card elevation-1">
                <div class="content-card__content">
                    <div id="tags">
                        @if ($tags->count())
                            <div id="tag-list">
                                @foreach ($tags as $tag)
                                    <div class="tag-wrapper">
                                        <a class="tag" href="{{ route('tags.view', $tag->slug) }}">
                                            {{ $tag->name }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div id="no-tags">
                                @lang("tessify-core::tags.overview_no_records")
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop