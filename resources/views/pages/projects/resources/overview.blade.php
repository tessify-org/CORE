@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.resources", $project) !!}
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
                        "page" => "resources",
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
                                <h1 id="project-title">{{ $project->title }}</h1>
                                <h2 id="project-subtitle">{{ $project->slogan }}</h2>
                            </div>
                            <div id="project-header__actions">
                                <div id="project-header__actions-left">
                                    <v-btn outlined href="{{ route('projects.view', $project->slug) }}" color="white">
                                        <i class="fas fa-arrow-left"></i>
                                        @lang("tessify-core::projects.back_to_project")
                                    </v-btn>
                                </div>
                                <div id="project-header__actions-right">
                                    <v-btn depressed href="{{ route('projects.resources.create', $project->slug) }}" color="primary">
                                        <i class="fas fa-plus"></i>
                                        @lang("tessify-core::projects.add_resources")
                                    </v-btn>
                                </div>
                            </div>
                        </div>
                        <!-- Content -->
                        <div id="project-content">
                        
                            <!-- Content header -->
                            <div id="project-content__header">
                                <div id="project-content__header-left">
                                
                                    <!-- Title -->
                                    <h1 id="project-title">@lang("tessify-core::projects.resources_title")</h1>

                                    <project-resource-overview
                                        :project="{{ $project->toJson() }}"
                                        :resources="{{ $resources->toJson() }}"
                                        :strings="{{ $strings->toJson() }}"
                                        :errors="{{ $errors->toJson() }}"
                                        :api-endpoints="{{ $apiEndpoints->toJson() }}">
                                    </project-resource-overview>

                                </div>
                            </div>

                        </div>
                    </div>


                </main>
            </div>

        </div>
    </div>
@stop