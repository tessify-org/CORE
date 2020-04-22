@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("dashboard") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title & subtitle -->
            <h1 class="page-title centered">@lang("tessify-core::dashboard.title")</h1>
            <h2 class="page-subtitle centered">{{ $greeting }}</h2>

            <!-- Dashboard -->
            <div id="dashboard">

                <!-- Statistics -->
                <div id="dashboard-stats">
                    <!-- Reputation points -->
                    <div class="dashboard-stat__wrapper">
                        <div class="dashboard-stat elevation-1">
                            <div class="dashboard-stat__icon">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div class="dashboard-stat__count">{{ $user->reputation_points }}</div>
                            <div class="dashboard-stat__text">@lang("tessify-core::dashboard.stat_reputation")</div>
                        </div>
                    </div>
                    <!-- Tasks completed -->
                    <div class="dashboard-stat__wrapper">
                        <div class="dashboard-stat elevation-1">
                            <div class="dashboard-stat__icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="dashboard-stat__count">{{ $numTasksCompleted }}</div>
                            <div class="dashboard-stat__text">@lang("tessify-core::dashboard.stat_tasks_completed")</div>
                        </div>
                    </div>
                    <!-- Projects completed -->
                    <div class="dashboard-stat__wrapper">
                        <div class="dashboard-stat elevation-1">
                            <div class="dashboard-stat__icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div class="dashboard-stat__count">{{ $numProjectsCompleted }}</div>
                            <div class="dashboard-stat__text">@lang("tessify-core::dashboard.stat_projects_completed")</div>
                        </div>
                    </div>
                    <!-- Reviews placed -->
                    <div class="dashboard-stat__wrapper">
                        <div class="dashboard-stat elevation-1">
                            <div class="dashboard-stat__icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="dashboard-stat__count">{{ $numReviewsPlaced }}</div>
                            <div class="dashboard-stat__text">@lang("tessify-core::dashboard.stat_reviews_posted")</div>
                        </div>
                    </div>
                </div>

                <!-- Columns -->
                <div id="dashboard-columns">
                    <div id="dashboard-columns__left">

                        <!-- Quick links -->
                        <h3 class="content-card__title">@lang("tessify-core::dashboard.ql_title")</h3>
                        <h4 class="content-card__description">@lang("tessify-core::dashboard.ql_description")</h4>
                        <div id="dashboard-quick-links">
                            <div class="quick-link__wrapper">
                                <div class="quick-link">
                                    <v-btn color="primary" block large href="{{ route('projects.create') }}">
                                        @lang("tessify-core::dashboard.ql_create_project")
                                    </v-btn>
                                </div>
                            </div>
                            <div class="quick-link__wrapper">
                                <div class="quick-link">
                                    <v-btn color="primary" block large href="{{ route('tasks.create') }}">
                                        @lang("tessify-core::dashboard.ql_create_task")
                                    </v-btn>
                                </div>
                            </div>
                            <div class="quick-link__wrapper">
                                <div class="quick-link">
                                    <v-btn color="primary" block large href="{{ route('notifications') }}" @if ($numUnreadNotifications == 0) disabled @endif>
                                        @lang("tessify-core::dashboard.ql_notifications", ["num" => $numUnreadNotifications])
                                    </v-btn>
                                </div>
                            </div>
                            <div class="quick-link__wrapper">
                                <div class="quick-link">
                                    <v-btn color="primary" block large href="{{ route('messages') }}" @if ($numUnreadMessages == 0) disabled @endif>
                                        @lang("tessify-core::dashboard.ql_messages", ["num" => $numUnreadMessages])
                                    </v-btn>
                                </div>
                            </div>
                            <div class="quick-link__wrapper">
                                <div class="quick-link">
                                    <v-btn color="primary" block large href="{{ route('reviews') }}" @if ($numReviewRequests == 0) disabled @endif>
                                        @lang("tessify-core::dashboard.ql_review_requests", ["num" => $numReviewRequests])
                                    </v-btn>
                                </div>
                            </div>
                            <div class="quick-link__wrapper">
                                <div class="quick-link">
                                    <v-btn color="primary" block large href="#" @if ($numEmailRequests == 0) disabled @endif>
                                        @lang("tessify-core::dashboard.ql_email_requests", ["num" => $numEmailRequests])
                                    </v-btn>
                                </div>
                            </div>
                        </div>

                        <!-- Feed -->
                        <h3 class="content-card__title">@lang("tessify-core::dashboard.feed_title")</h3>
                        <h4 class="content-card__description">@lang("tessify-core::dashboard.feed_description")</h4>
                        <div class="content-card mb elevation-1">
                            <div class="content-card__content">
                                <dashboard-activity-feed
                                    :entries="{{ $feedActivities->toJson() }}"
                                    no-records-text="@lang('tessify-core::dashboard.feed_empty')">
                                </dashboard-activity-feed>
                            </div>
                        </div>

                        <!-- Following -->
                        <div id="dashboard-following">
                            <div id="dashboard-following__title">@lang("tessify-core::dashboard.following_title")</div>
                            <div id="dashboard-following__content">
                                <!-- Users -->
                                <div class="dashboard-following__column-wrapper">
                                    <div class="dashboard-following__column">
                                        <dashboard-following-button
                                            icon='<i class="fas fa-user"></i>'
                                            text="@lang('tessify-core::dashboard.following_users')"
                                            :data='{{ $followings->toJson() }}'
                                            dialog-title-text="@lang('tessify-core::dashboard.following_users_dialog_title')">
                                        </dashboard-following-button>
                                    </div>
                                </div>
                                <!-- Projects -->
                                <div class="dashboard-following__column-wrapper">
                                    <div class="dashboard-following__column">
                                        <dashboard-following-button
                                            icon='<i class="fas fa-rocket"></i>'
                                            text="@lang('tessify-core::dashboard.following_projects')"
                                            :data='{{ $subscribedProjects->toJson() }}'
                                            dialog-title-text="@lang('tessify-core::dashboard.following_projects_dialog_title')">
                                        </dashboard-following-button>
                                    </div>
                                </div>
                                <!-- Tasks -->
                                <div class="dashboard-following__column-wrapper">
                                    <div class="dashboard-following__column">
                                        <dashboard-following-button
                                            icon='<i class="fas fa-list-ul"></i>'
                                            text="@lang('tessify-core::dashboard.following_tasks')"
                                            :data='{{ $subscribedTasks->toJson() }}'
                                            dialog-title-text="@lang('tessify-core::dashboard.following_tasks_dialog_title')">
                                        </dashboard-following-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div id="dashboard-columns__right">

                        <!-- Current tasks -->
                        <h3 class="content-card__title">@lang("tessify-core::dashboard.tasks_title")</h3>
                        <h4 class="content-card__description">@lang("tessify-core::dashboard.tasks_description")</h4>
                        <div class="content-card mb elevation-1">
                            <dashboard-my-tasks
                                :tasks="{{ $myTasks->toJson() }}"
                                no-records-text="@lang('tessify-core::dashboard.tasks_empty')">
                            </dashboard-my-tasks>
                        </div>
                        
                        <!-- My projects -->
                        <h3 class="content-card__title">@lang("tessify-core::dashboard.projects_title")</h3>
                        <h4 class="content-card__description">@lang("tessify-core::dashboard.projects_description")</h4>
                        <div class="content-card mb elevation-1">
                            <dashboard-my-projects
                                :projects="{{ $myProjects->toJson() }}"
                                no-records-text="@lang('tessify-core::dashboard.projects_empty')">
                            </dashboard-my-projects>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
@stop
