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
                

                <!-- Interactive view project -->
                <project-view
                    :project="{{ $project->toJson() }}"
                    :user="{{ $user->toJson() }}"
                    :comments="{{ $comments->toJson() }}"
                    create-comment-api-endpoint="{{ route('api.comments.create.post') }}"
                    update-comment-api-endpoint="{{ route('api.comments.update.post') }}"
                    delete-comment-api-endpoint="{{ route('api.comments.delete.post') }}"
                    create-team-member-application-api-endpoint="{{ route('api.team-member-applications.create.post') }}"
                    update-team-member-application-api-endpoint="{{ route('api.team-member-applications.update.post') }}"
                    delete-team-member-application-api-endpoint="{{ route('api.team-member-applications.delete.post') }}"
                    accept-team-member-application-api-endpoint="{{ route('api.team-member-applications.accept.post') }}"
                    deny-team-member-application-api-endpoint="{{ route('api.team-member-applications.deny.post') }}">
                </job-view>

            </div>
        </div>
        
    </div>
@stop