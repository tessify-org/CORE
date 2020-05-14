@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.team", $project) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Task page -->
            <div id="view-project">
                <aside id="view-project__sidebar">

                    @include("tessify-core::partials.projects.view-sidebar", [
                        "project" => $project,
                        "page" => "team",
                    ])

                </aside>
                <main id="view-project__content">

                    <!-- Project information -->
                    <div id="project" class="elevation-2">
                        <!-- Header -->
                        <div id="project-header">
                            <div id="project-header__bg" style="background-image: url({{ asset($project->header_image_url) }})"></div>
                            <div id="project-header__bg-overlay"></div>
                            <div id="project-header__text">
                                <h1 id="project-title">@lang("tessify-core::projects.view_title")</h1>
                                <h2 id="project-subtitle">{{ $project->slogan }}</h2>
                            </div>
                        </div>
                        <!-- Content -->
                        <div id="project-content">
                        
                            <!-- Content header -->
                            <div id="project-content__header">
                                <div id="project-content__header-left">
                                    
                                    <!-- Application overview -->

                                    <!-- Team member overview -->
                                    <project-team-member-overview
                                        :project="{{ $project->toJson() }}"
                                        :members="{{ $members->toJson() }}"
                                        :strings="{{ $memberOverviewStrings->toJson() }}">
                                    </project-team-member-overview>

                                </div>
                            </div>

                        </div>
                    </div>


                </main>
            </div>

        </div>
    </div>
@stop