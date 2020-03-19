@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.tasks", $project) !!}
@stop

@section("content")
    <div id="project">

        <!-- Header -->
        <div id="project-header" style="background-image: url({{ asset($project->header_image_url) }});">
            <div id="project-header__overlay"></div>
            <div id="project-header__content" class="content-section">

                <div id="project-header__text">
                    <h1 id="project-header__title">{{ $project->title }}</h1>
                    <h2 id="project-header__slogan">{{ $project->slogan }}</h2>
                </div>

            </div>
        </div>

        <!-- Content -->
        <div id="project-content" class="content-section__wrapper">
            <div class="content-section pt50">

                <!-- Feedback -->
                @include("tessify-core::partials.feedback")

                <!-- Navigation -->
                @include("tessify-core::partials.projects.navigation", [
                    "page" => "tasks",
                    "project" => $project,    
                ])

                <task-overview
                    :tasks="{{ json_encode($tasks) }}"
                    create-task-href="{{ route('tasks.create', $project->slug) }}"
                    title-open-text="@lang('tessify-core::projects.tasks_overview_open')"
                    title-in-progress-text="@lang('tessify-core::projects.tasks_overview_in_progress')"
                    title-completed-text="@lang('tessify-core::projects.tasks_overview_completed')"
                    title-text="@lang('tessify-core::projects.tasks_overview_title')"
                    category-text="@lang('tessify-core::projects.tasks_overview_category')"
                    complexity-text="@lang('tessify-core::projects.tasks_overview_complexity')"
                    no-open-tasks-text="@lang('tessify-core::projects.tasks_overview_open_empty')"
                    no-in-progress-tasks-text="@lang('tessify-core::projects.tasks_overview_in_progress_empty')"
                    no-completed-tasks-text="@lang('tessify-core::projects.tasks_overview_completed_empty')"
                    submit-text="@lang('tessify-core::projects.tasks_overview_create')">
                </task-overview>

            </div>
        </div>

    </div>
@stop