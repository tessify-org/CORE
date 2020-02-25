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
                    <task-dashboard-sidebar-search-bar></task-dashboard-sidebar-search-bar>

                    <!-- Categories -->
                    <task-dashboard-sidebar-categories
                        :categories="{{ $categories->toJson() }}">
                    </task-dashboard-sidebar-categories>

                    <!-- Seniorities -->
                    <task-dashboard-sidebar-seniorities
                        :seniorities="{{ $seniorities->toJson() }}">
                    </task-dashboard-sidebar-seniorities>

                    <!-- Duration -->
                    <task-dashboard-sidebar-duration></task-dashboard-sidebar-duration>

                </div>
                <div id="task-dashboard__content">

                    <!-- Task overview -->
                    <task-dashboard-overview
                        :tasks="{{ $tasks->toJson() }}">
                    </task-dashboard-overview>

                </div>
            </div>

        </div>
    </div>
@stop