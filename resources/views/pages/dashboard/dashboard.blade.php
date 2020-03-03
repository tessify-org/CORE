@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("dashboard") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">@lang("tessify-core::dashboard.title")</h1>
            <h2 class="page-subtitle centered">@lang("tessify-core::dashboard.welcome", ["name" => $user->formattedName])</h2>

            <div id="dashboard">

                <!-- Statistics -->
                <div id="dashboard-stats">
                    <!-- Reputation points -->
                    <div class="dashboard-stat__wrapper">
                        <div class="dashboard-stat elevation-1">
                            <div class="dashboard-stat__count">{{ $user->reputation_points }}</div>
                            <div class="dashboard-stat__text">@lang("tessify-core::dashboard.stat_reputation")</div>
                        </div>
                    </div>
                    <!-- Tasks completed -->
                    <div class="dashboard-stat__wrapper">
                        <div class="dashboard-stat elevation-1">
                            <div class="dashboard-stat__count">{{ $numTasksCompleted }}</div>
                            <div class="dashboard-stat__text">@lang("tessify-core::dashboard.stat_tasks_completed")</div>
                        </div>
                    </div>
                    <!-- Projects completed -->
                    <div class="dashboard-stat__wrapper">
                        <div class="dashboard-stat elevation-1">
                            <div class="dashboard-stat__count">{{ $numProjectsCompleted }}</div>
                            <div class="dashboard-stat__text">@lang("tessify-core::dashboard.stat_projects_completed")</div>
                        </div>
                    </div>
                    <!-- Reviews placed -->
                    <div class="dashboard-stat__wrapper">
                        <div class="dashboard-stat elevation-1">
                            <div class="dashboard-stat__count">{{ $numReviewsPlaced }}</div>
                            <div class="dashboard-stat__text">@lang("tessify-core::dashboard.stat_reviews_posted")</div>
                        </div>
                    </div>
                </div>

                <!-- Columns -->
                <div id="dashboard-columns">
                    <div id="dashboard-columns__left">

                        <!-- Feed -->
                        <h3 class="content-card__title">@lang("tessify-core::dashboard.feed_title")</h3>
                        <div class="content-card mb elevation-1">
                            <div class="content-card__content">
                                @lang("tessify-core::dashboard.feed_empty")
                            </div>
                        </div>
                        
                    </div>
                    <div id="dashboard-columns__right">

                        <!-- Current tasks -->
                        <h3 class="content-card__title">@lang("tessify-core::dashboard.tasks_title")</h3>
                        <div class="content-card mb elevation-1">
                            <dashboard-my-tasks
                                :tasks="{{ $myTasks->toJson() }}"
                                no-records-text="@lang('tessify-core::dashboard.tasks_empty')">
                            </dashboard-my-tasks>
                        </div>

                        <!-- My projects -->
                        <h3 class="content-card__title">@lang("tessify-core::dashboard.projects_title")</h3>
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
