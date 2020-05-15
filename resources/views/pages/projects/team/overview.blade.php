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
                            <!-- Text -->
                            <div id="project-header__text">
                                <!-- Project title & slogan -->
                                <h1 id="project-title">{{ $project->title }}</h1>
                                <h2 id="project-subtitle">{{ $project->slogan }}</h2>
                            </div>
                            <!-- Back button -->
                            <div id="project-header__actions">
                                <v-btn outlined href="{{ route('projects.view', $project->slug) }}" color="white">
                                    <i class="fas fa-arrow-left"></i>
                                    @lang("tessify-core::projects.back_to_project")
                                </v-btn>
                            </div>
                        </div>
                        <!-- Content -->
                        <div id="project-content">
                        
                            <!-- Content header -->
                            <div id="project-content__header">
                                <div id="project-content__header-left">

                                    <!-- Team member overview -->
                                    <project-team-member-overview
                                        :project="{{ $project->toJson() }}"
                                        :members="{{ $members->toJson() }}"
                                        :strings="{{ $memberOverviewStrings->toJson() }}"
                                        :api-endpoints="{{ $memberOverviewApiEndpoints->toJson() }}">
                                    </project-team-member-overview>
                                    
                                    <!-- Application overview -->
                                    <project-team-member-application-overview
                                        :project="{{ $project->toJson() }}"
                                        :applications="{{ $applications->toJson() }}"
                                        :strings="{{ $applicationOverviewStrings->toJson() }}"
                                        :api-endpoints="{{ $applicationOverviewApiEndpoints->toJson() }}">
                                    </project-team-member-application-overview>

                                </div>
                            </div>

                        </div>
                    </div>


                </main>
            </div>

        </div>
    </div>
@stop