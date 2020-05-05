@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.view", $project) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- View project -->
            <div id="view-project">
                <div id="view-project__sidebar">

                    @include("tessify-core::partials.projects.view-sidebar", [
                        "project" => $project,
                    ])

                </div>
                <div id="view-project__content">

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
                                    <!-- Project title -->
                                    <h1 id="project-content__header-title">{{ $project->title }}</h1>
                                    <!-- Tags -->
                                    @if (count($project->tags))
                                        <div id="project-tags" class="tags">
                                            @foreach ($project->tags as $tag)       
                                                <div class="tag-wrapper">
                                                    <div class="tag">
                                                        {{ $tag->name }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <!-- Details -->
                                    <div id="project-details">
                                        <!-- Category -->
                                        <div class="project-detail">
                                            <div class="project-detail__key">@lang("tessify-core::projects.view_category")</div>
                                            <div class="project-detail__val">{{ $project->category->label }}</div>
                                        </div>
                                        <!-- Deadline -->
                                        @if ($project->has_deadline)
                                            <div class="project-detail">
                                                <div class="project-detail__key">@lang("tessify-core::projects.view_deadline")</div>
                                                <div class="project-detail__val">{{ $project->ends_at->format("d-m-Y H:m:s") }}</div>
                                            </div>
                                        @endif
                                        <!-- Budget -->
                                        @if ($project->budget > 0)
                                            <div class="project-detail">
                                                <div class="project-detail__key">@lang("tessify-core::projects.view_budget")</div>
                                                <div class="project-detail__val">&euro; {{ number_format($project->budget, 2) }}</div>
                                            </div>
                                        @endif
                                        <!-- Project code -->
                                        @if (!is_null($project->project_code))
                                            <div class="project-detail">
                                                <div class="project-detail__key">@lang("tessify-core::projects.view_project_code")</div>
                                                <div class="project-detail__val">{{ $project->project_code }}</div>
                                            </div>
                                        @endif
                                        <!-- -->
                                        <!-- <div class="project-detail">
                                            <div class="project-detail__key"></div>
                                            <div class="project-detail__val"></div>
                                        </div> -->
                                    </div>
                                </div>
                                <div id="project-content__header-right">
                                    <!-- Join & Leave -->
                                    <div id="primary-action">
                                        
                                        <!-- Project has been closed -->
                                        @if ($project->status->name == "closed")

                                            <!-- Disabled join button -->
                                            <v-tooltip top>
                                                <template v-slot:activator="{ on }">
                                                    <v-btn color="primary" depressed block disabled v-on="on">
                                                        <i class="far fa-thumbs-up"></i>
                                                        @lang("tessify-core::projects.view_join")
                                                    </v-btn>
                                                </template>
                                                <span>@lang("tessify-core::projects.view_join_disabled_closed")</span>
                                            </v-tooltip>

                                        <!-- Project is open -->
                                        @else

                                            <!-- User is team member -->
                                            @if ($project->is_team_member)

                                                <!-- Leave button -->
                                                <v-btn color="red" href="{{ route('projects.team.leave', $project->slug) }}" depressed block dark>
                                                    <i class="fas fa-door-open"></i>
                                                    @lang("tessify-core::projects.view_leave")
                                                </v-btn>

                                            <!-- User is not a team member -->
                                            @else
                                                
                                                <!-- Join button -->
                                                <v-btn color="primary" href="{{ route('projects.team.apply', $project->slug) }}" depressed block>
                                                    <i class="far fa-thumbs-up"></i>
                                                    @lang("tessify-core::projects.view_join")
                                                </v-btn>

                                            @endif

                                        @endif

                                    </div>
                                    <!-- Follow & Invite -->
                                    <div id="secondary-actions">
                                        <div class="secondary-action">
                                            @if (!Auth::user()->hasSubscribed($project))
                                                <!-- Follow button -->
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on }">
                                                        <v-btn href="{{ route('projects.subscribe', ['slug' => $project->slug]) }}" class="icon-only" small depressed v-on="on">
                                                            <i class="far fa-eye"></i>
                                                        </v-btn>
                                                    </template>
                                                    <span>@lang("tessify-core::projects.view_subscribe")</span>
                                                </v-tooltip>
                                            @else
                                                <!-- Unfollow button -->
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on }">
                                                        <v-btn href="{{ route('projects.unsubscribe', ['slug' => $project->slug]) }}" class="icon-only" small depressed v-on="on">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </v-btn>
                                                    </template>
                                                    <span>@lang("tessify-core::projects.view_unsubscribe")</span>
                                                </v-tooltip>
                                            @endif
                                        </div>
                                        <div class="secondary-action">
                                            <!-- Invite friend button -->
                                            <project-invite-button
                                                :project="{{ $project->toJson() }}"
                                                :users="{{ $users->toJson() }}"
                                                :strings="{{ $inviteButtonStrings->toJson() }}"
                                                endpoint="{{ route('projects.invite', $project->slug) }}">
                                            </project-invite-button>
                                        </div>
                                    </div>
                                    <!-- Ask question -->
                                    <div id="ask-question">
                                        <project-ask-question-button
                                            :project="{{ $project->toJson() }}"
                                            :users="{{ $users->toJson() }}"
                                            :strings="{{ $askQuestionStrings->toJson() }}"
                                            endpoint="{{ route('projects.ask-question.post', $project->slug) }}">
                                        </project-ask-question-button>
                                    </div>
                                    <!-- Share -->
                                    <div id="share-project">
                                        <div id="share-project__text">@lang("tessify-core::projects.view_share_project")</div>
                                        <div id="share-project__socials">
                                            <!-- Facebook -->
                                            <div class="social-wrapper">
                                                <a class="social" href="#">
                                                    <i class="fab fa-facebook-square"></i>
                                                </a>
                                            </div>
                                            <!-- Twitter -->
                                            <div class="social-wrapper">
                                                <a class="social" href="#">
                                                    <i class="fab fa-twitter-square"></i>
                                                </a>
                                            </div>
                                            <!-- LinkedIn -->
                                            <div class="social-wrapper">
                                                <a class="social" href="#">
                                                    <i class="fab fa-linkedin"></i>
                                                </a>
                                            </div>
                                            <!-- WhatsApp -->
                                            <div class="social-wrapper">
                                                <a class="social" href="#">
                                                    <i class="fab fa-whatsapp-square"></i>
                                                </a>
                                            </div>
                                            <!-- E-mail -->
                                            <div class="social-wrapper">
                                                <a class="social" href="#">
                                                    <i class="fas fa-envelope-square"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Project description -->
                            <div id="project-description">
                                <div id="project-description__title">@lang("tessify-core::projects.view_description")</div>
                                <div id="project-description__text">
                                    {!! nl2br($project->description) !!}
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Page controls -->
                    <div id="project-page-controls" class="page-controls">
                        <div class="page-controls__right">
                            @can("update", $project)
                                <v-btn depressed color="warning" href="{{ route('projects.edit', $project->slug) }}">
                                    <i class="fas fa-pen-square"></i>
                                    @lang("tessify-core::general.edit")
                                </v-btn>
                            @endcan
                            @can("delete", $project)
                                <v-btn depressed color="red" dark href="{{ route('projects.delete', $project->slug) }}">
                                    <i class="fas fa-trash"></i>
                                    @lang("tessify-core::general.delete")
                                </v-btn>
                            @endcan
                        </div>
                    </div>
                
                </div>
            </div>

        </div>
    </div>
@stop