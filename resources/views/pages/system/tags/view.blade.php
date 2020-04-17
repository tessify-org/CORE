@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tags.view", $tag) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">{{ $tag->name }}</h1>
            <h2 class="page-subtitle__subtext centered">@lang("tessify-core::tags.view_title")</h2>
        
            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Projects -->
            <div class="content-card elevation-1 mb">
                <div class="content-card__content">
                    <h3 class="content-subtitle">@lang("tessify-core::tags.view_projects")</h3>
                    @if ($tag->projects->count())
                        <div class="tag-overview">
                            @foreach ($tag->projects as $project)
                                <a class="tag-overview__entry" href="{{ route('projects.view', $project->slug) }}">
                                    <span class="entry-col">{{ $project->title }}</span>
                                    <span class="entry-col">{{ $project->status->label }}</span>
                                    <span class="entry-col">{{ $project->author->formatted_name }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        @lang("tessify-core::tags.view_no_projects")
                    @endif
                </div>
            </div>

            <!-- Tasks -->
            <div class="content-card elevation-1">
                <div class="content-card__content">
                    <h3 class="content-subtitle">@lang("tessify-core::tags.view_tasks")</h3>
                    @if ($tag->tasks->count())
                        <div class="tag-overview">
                            @foreach ($tag->tasks as $task)
                                <a class="tag-overview__entry" href="{{ route('tasks.view', $task->slug) }}">
                                    <span class="entry-col">{{ $task->title }}</span>
                                    <span class="entry-col">{{ $task->status->label }}</span>
                                    <span class="entry-col">{{ $task->author->formatted_name }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        @lang("tessify-core::tags.view_no_tasks")
                    @endif
                </div>
            </div>

        </div>
    </div>
@stop