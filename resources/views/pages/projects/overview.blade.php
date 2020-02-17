@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">
                @lang("tessify-core::projects.overview_title")
            </h1>
        
            @include("partials.feedback")

            @if ($projects->count() > 0)
                <div id="projects" class="elevation-1">
                    <div id="projects-header">
                        <div class="projects-header__column">
                            @lang("tessify-core::projects.overview_table_title")
                        </div>
                        <div class="projects-header__column">
                            @lang("tessify-core::projects.overview_table_status")
                        </div>
                    </div>
                    @foreach ($projects as $project)
                        <a class="project" href="{{ route('projects.view', $project->slug) }}">
                            <span class="project-title">{{ $project->title }}</span>
                            <span class="project-status">{{ $project->status->label }}</span>
                        </a>
                    @endforeach
                </div>
            @else
                <div id="no-projects" class="elevation-1">
                    @lang("tessify-core::projects.overview_empty")
                </div>
            @endif

            <div class="page-controls mt">
                <div class="page-controls__right">
                    <v-btn color="success" href="{{ route('projects.create') }}">
                        <i class="fas fa-plus"></i>
                        @lang("tessify-core::projects.overview_title")
                    </v-btn>
                </div>
            </div>

        </div>
    </div>
@stop