@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.view", $project) !!}
@stop

@section("content")
    <div id="project">

        <!-- Header -->
        <div id="project-header" style="background-image: url({{ asset($project->header_image_url) }});">
            <div id="project-header__overlay"></div>
            <div id="project-header__content" class="content-section">

                <!-- Feedback -->
                @include("tessify-core::partials.feedback")

                <div id="project-header__text">
                    <h1 id="project-header__title">{{ $project->title }}</h1>
                    <h2 id="project-header__slogan">{{ $project->slogan }}</h2>
                </div>

            </div>
        </div>

        <!-- Content -->
        <div id="project-content" class="content-section__wrapper">
            <div class="content-section">

                <!-- Navigation -->
                @include("tessify-core::partials.projects.navigation", [
                    "page" => "team-applications",
                    "project" => $project,    
                ])

                <!-- Project's team member applications -->
                <div id="project-member-applications" class="content-box elevation-1">

                    <h3 class="content-subtitle">Team member applications</h3>

                    <project-team-applications
                        :project="{{ $project->toJson() }}"
                        :applications="{{ $teamApplications->toJson() }}"
                        create-team-member-application-api-endpoint="{{ route('api.team-member-applications.create.post') }}"
                        update-team-member-application-api-endpoint="{{ route('api.team-member-applications.update.post') }}"
                        delete-team-member-application-api-endpoint="{{ route('api.team-member-applications.delete.post') }}"
                        accept-team-member-application-api-endpoint="{{ route('api.team-member-applications.accept.post') }}"
                        deny-team-member-application-api-endpoint="{{ route('api.team-member-applications.deny.post') }}">
                    </project-team-applications>

                </div>

            </div>
        </div>

    </div>
@stop