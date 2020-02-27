@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">@lang("tessify-core::tasks.overview_title")</h1>
            <h2 class="page-subtitle centered">@lang("tessify-core::tasks.overview_subtitle")</h2>
        
            @include("tessify-core::partials.feedback")

            <div id="task-dashboard">
                <div id="task-dashboard__sidebar">

                    <!-- Search bar -->
                    <task-dashboard-sidebar-search-bar
                        title="@lang('tessify-core::tasks.overview_sidebar_search')">
                    </task-dashboard-sidebar-search-bar>

                    <!-- Status -->
                    <task-dashboard-sidebar-statuses
                        title="@lang('tessify-core::tasks.overview_sidebar_statuses')"
                        no-records-text="@lang('tessify-core::tasks.overview_sidebar_statuses_empty')"
                        :statuses="{{ $statuses->toJson() }}">
                    </task-dashboard-sidebar-statuses>

                    <!-- Categories -->
                    <task-dashboard-sidebar-categories
                        title="@lang('tessify-core::tasks.overview_sidebar_categories')"
                        no-records-text="@lang('tessify-core::tasks.overview_sidebar_categories_empty')"
                        :categories="{{ $categories->toJson() }}">
                    </task-dashboard-sidebar-categories>

                    <!-- Skills -->
                    <task-dashboard-sidebar-skills
                        title="@lang('tessify-core::tasks.overview_sidebar_skills')"
                        no-records-text="@lang('tessify-core::tasks.overview_sidebar_skills_empty')"
                        :skills="{{ $skills->toJson() }}">
                    </task-dashboard-sidebar-skills>

                    <!-- Seniorities -->
                    <task-dashboard-sidebar-seniorities
                        title="@lang('tessify-core::tasks.overview_sidebar_seniorities')"
                        no-records-text="@lang('tessify-core::tasks.overview_sidebar_seniorities_empty')"
                        :seniorities="{{ $seniorities->toJson() }}">
                    </task-dashboard-sidebar-seniorities>

                    <!-- Duration -->
                    <task-dashboard-sidebar-duration
                        title="@lang('tessify-core::tasks.overview_sidebar_timespan')">
                    </task-dashboard-sidebar-duration>

                </div>
                <div id="task-dashboard__content">

                    <!-- Task overview -->
                    <task-dashboard-overview
                        :tasks="{{ $tasks->toJson() }}"
                        description-text="@lang('tessify-core::tasks.overview_description')"
                        skills-text="@lang('tessify-core::tasks.overview_skills')"
                        complexity-text="@lang('tessify-core::tasks.overview_complexity')"
                        view-text="@lang('tessify-core::tasks.overview_view')"
                        no-tasks-text="@lang('tessify-core::tasks.overview_no_tasks')">
                    </task-dashboard-overview>

                </div>
            </div>

        </div>
    </div>
@stop