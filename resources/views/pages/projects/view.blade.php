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
                    "page" => "info",
                    "project" => $project,                    
                ])

                <!-- Project information -->
                <div id="project-info">

                    <!-- Main content -->
                    <div id="project-info__main">

                        <!-- Description -->
                        <div class="content-box elevation-1">
                            <h3 class="content-subtitle">@lang("tessify-core::projects.view_description")</h3>
                            <div id="project-description">
                                {!! nl2br($project->description) !!}
                            </div>
                        </div>

                        <!-- Resources -->
                        <div class="content-box elevation-1">
                            <h3 class="content-subtitle">@lang("tessify-core::projects.view_resources")</h3>
                            <project-resource-list
                                :resources="{{ $resources->toJson() }}"
                                empty-text="@lang('tessify-core::projects.view_no_resources')">
                            </project-resource-list>
                        </div>
                        
                        <!-- Comments -->
                        <div class="content-box elevation-1">
                            <comments
                                :user="{{ $user->toJson() }}"
                                :comments="{{ $comments->toJson() }}"
                                per-page="3"
                                target-type="project"
                                target-id="{{ $project->id }}"
                                create-comment-api-endpoint="{{ route('api.comments.create.post') }}"
                                update-comment-api-endpoint="{{ route('api.comments.update.post') }}"
                                delete-comment-api-endpoint="{{ route('api.comments.delete.post') }}">
                            </comments>
                        </div>

                    </div>

                    <!-- Sidebar -->
                    <div id="project-info__sidebar">

                        <!-- Status -->
                        <div class="content-box elevation-1">
                            <h3 class="content-subtitle">
                                @lang("tessify-core::projects.view_owner")
                            </h3>
                            <user-pill 
                                dark
                                :user="{{ $author->toJson() }}">
                            </user-pill>
                        </div>

                        <!-- Details -->
                        <div class="content-box elevation-1">
                            <h3 class="content-subtitle">
                                @lang("tessify-core::projects.view_details")
                            </h3>
                            <div class="details compact bordered mb-0">
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::projects.view_category")</div>
                                    <div class="val">{{ $project->category->label }}</div>
                                </div>
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::projects.view_work_method")</div>
                                    <div class="val">{{ $project->workMethod->label }}</div>
                                </div>
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::projects.view_start_date")</div>
                                    <div class="val">{{ $project->starts_at->format("d-m-Y") }}</div>
                                </div>
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::projects.view_end_date")</div>
                                    <div class="val">{{ $project->ends_at->format("d-m-Y") }}</div>
                                </div>
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::projects.view_created_at")</div>
                                    <div class="val">{{ $project->created_at->format("d-m-Y") }}</div>
                                </div>
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::projects.view_updated_at")</div>
                                    <div class="val">{{ $project->updated_at->format("d-m-Y") }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        @canany(["update", "delete"], $project)
                            <div class="content-box elevation-1">
                                <h3 class="content-subtitle">
                                    @lang("tessify-core::projects.view_actions")
                                </h3>
                                <div id="project-actions">
                                    @can("update", $project)
                                        <v-btn depressed block color="warning" href="{{ route('projects.edit', $project->slug) }}">
                                            <i class="fas fa-pen-square"></i>
                                            @lang("tessify-core::general.edit")
                                        </v-btn>
                                    @endcan
                                    @can("delete", $project)
                                        <v-btn depressed block color="red" dark href="{{ route('projects.delete', $project->slug) }}">
                                            <i class="fas fa-trash"></i>
                                            @lang("tessify-core::general.delete")
                                        </v-btn>
                                    @endcan
                                </div>
                            </div>
                        @endcanany

                    </div>

                </div>

                <!-- Interactive view project -->
                <!-- <project-view
                    :project="{{ $project->toJson() }}"
                    :user="{{ $user->toJson() }}"
                    :comments="{{ $comments->toJson() }}"
                    create-comment-api-endpoint=""
                    update-comment-api-endpoint="{{ route('api.comments.update.post') }}"
                    delete-comment-api-endpoint="{{ route('api.comments.delete.post') }}"
                    create-team-member-application-api-endpoint="{{ route('api.team-member-applications.create.post') }}"
                    update-team-member-application-api-endpoint="{{ route('api.team-member-applications.update.post') }}"
                    delete-team-member-application-api-endpoint="{{ route('api.team-member-applications.delete.post') }}"
                    accept-team-member-application-api-endpoint="{{ route('api.team-member-applications.accept.post') }}"
                    deny-team-member-application-api-endpoint="{{ route('api.team-member-applications.deny.post') }}">
                </project-view> -->

            </div>
        </div>
        
    </div>
@stop