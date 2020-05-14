@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects") !!}
@stop

@section("content")
    <div id="project-overview">
        <!-- Header -->
        <div id="project-overview__header">
            <div id="project-overview__header-overlay"></div>
            <div id="project-overview__header-illustration__wrapper">
                <div id="project-overview__header-illustration__inner">
                    <div id="project-overview__header-illustration" style="background-image: url({{ asset('storage/images/undraw/organizing_projects.svg') }})"></div>
                </div>
            </div>
            <div id="project-overview__header-content" class="content-section">
                <div id="project-overview__header-text">
                    <h1 class="page-title centered">@lang("tessify-core::projects.overview_title")</h1>
                    <h2 class="page-subtitle centered">@lang("tessify-core::projects.overview_subtitle", ["num_projects" => $projects->count()])</h2>
                    <v-btn color="primary" outlined href="{{ route('projects.create') }}">
                        <i class="fas fa-plus"></i>
                        @lang("tessify-core::projects.overview_create_cta")
                    </v-btn>
                </div>
            </div>
        </div>
        <!-- Content -->
        <div id="project-overview__content" class="content-section__wrapper">
            <div class="content-section pt50">
                
                <!-- Feedback -->
                @include("tessify-core::partials.feedback")

                <!-- Projects -->
                <project-overview
                    :projects="{{ $projects->toJson() }}"
                    :statuses="{{ $statuses->toJson() }}"
                    :categories="{{ $categories->toJson() }}"
                    :strings="{{ $strings->toJson() }}">
                </project-overview>

                <!-- Dashboard
                <div id="project-dashboard">
                    <div id="project-dashboard__sidebar">

                        <project-dashboard-sidebar-search-bar
                            title="@lang('tessify-core::projects.overview_sidebar_search')">
                        </project-dashboard-sidebar-search-bar>

                        <project-dashboard-sidebar-statuses
                            :statuses="{{ $statuses->toJson() }}"
                            title="@lang('tessify-core::projects.overview_sidebar_statuses')"
                            hint="@lang('tessify-core::projects.overview_sidebar_statuses_hint')"
                            no-records-text="@lang('tessify-core::projects.overview_sidebar_statuses_empty')">
                        </project-dashboard-sidebar-statuses>
                        
                        <project-dashboard-sidebar-categories
                            :categories="{{ $categories->toJson() }}"
                            title="@lang('tessify-core::projects.overview_sidebar_categories')"
                            hint="@lang('tessify-core::projects.overview_sidebar_categories_hint')"
                            no-records-text="@lang('tessify-core::projects.overview_sidebar_categories_empty')">
                        </project-dashboard-sidebar-categories>

                    </div>
                    <div id="project-dashboard__content">

                        <project-dashboard-overview
                            :projects="{{ $projects->toJson() }}"
                            description-text="@lang('tessify-core::projects.overview_description')"
                            view-text="@lang('tessify-core::projects.overview_view')"
                            no-projects-text="@lang('tessify-core::projects.overview_no_projects')">
                        </project-dashboard-overview>

                    </div>
                </div>
                -->
                
            </div>
        </div>
    </div>

@stop