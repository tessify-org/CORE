@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.reviews", $project) !!}
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
                        "page" => "reviews",
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
                                
                                    <!-- Title -->
                                    <h1 id="project-title">@lang("tessify-core::projects.reviews_title")</h1>

                                    <!-- Review overview -->
                                    <project-review-overview
                                        :project="{{ $project->toJson() }}"
                                        :reviews="{{ $reviews->toJson() }}"
                                        :strings="{{ $strings->toJson() }}">
                                    </project-review-overview>

                                </div>
                            </div>


                        </div>
                    </div>


                </main>
            </div>

        </div>
    </div>
@stop