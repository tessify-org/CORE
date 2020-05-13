@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("organizations.view", $organization) !!}
@stop

@section("content")
    <div id="organization">
        
        <!-- Header -->
        <div id="organization-header">
            <div id="organization-header__overlay"></div>
            <div id="organization-header__content">
                <div id="organization-header__text">
                    <h1 id="organization-header__title">{{ $organization->name }}</h1>
                </div>
                <div id="organization-header__actions">
                    @if (!Auth::user()->hasSubscribed($organization))
                        <v-btn depressed href="{{ route('organizations.subscribe', ['slug' => $organization->slug]) }}">
                            <i class="fas fa-check-circle"></i>
                            @lang("tessify-core::organizations.view_subscribe")
                        </v-btn>
                    @else
                        <v-btn depressed href="{{ route('organizations.unsubscribe', ['slug' => $organization->slug]) }}">
                            <i class="fas fa-times-circle"></i>
                            @lang("tessify-core::organizations.view_unsubscribe")
                        </v-btn>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content -->
        <div id="organization-content">
            <div class="content-section__wrapper">
                <div class="content-section">

                    <!-- Feedback -->
                    @include("tessify-core::partials.feedback")

                    <!-- Content -->
                    <div class="content-card elevation-1 mb">
                        <div class="content-card__content">
                            <h3 class="content-subtitle">@lang("tessify-core::ministries.view_details")</h3>
                            <div class="details no-padding mb-0">
                                <!-- Ministry -->
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::organizations.view_ministry")</div>
                                    <div class="val">
                                        <a href="{{ route('ministries.view', $organization->ministry->slug) }}">
                                            {{ $organization->ministry->name }}
                                        </a>
                                    </div> 
                                </div>
                                <!-- Name -->
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::organizations.view_name")</div>
                                    <div class="val">{{ $organization->name }}</div> 
                                </div>
                                <!-- Abbreviation -->
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::organizations.view_abbreviation")</div>
                                    <div class="val">{{ $organization->abbreviation }}</div> 
                                </div>
                                <!-- Description -->
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::organizations.view_description")</div>
                                    <div class="val">{{ $organization->description }}</div> 
                                </div>
                                <!-- Website -->
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::organizations.view_website")</div>
                                    <div class="val">
                                        <a href="{{ $organization->website_url }}" target="_blank">
                                            {{ $organization->website_url }}
                                        </a>
                                    </div> 
                                </div>
                                <!-- Last updated on -->
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::organizations.view_last_update")</div>
                                    <div class="val">{{ $organization->updated_at->format("d-m-Y H:m:s") }}</div> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Departments -->
                    <div class="content-card elevation-1 mb">
                        <div class="content-card__content">
                            <h3 class="content-subtitle">@lang("tessify-core::organizations.view_departments")</h3>
                            <div id="organization-departments">
                                @if ($organization->departments->count())
                                    <div id="departments">
                                        @foreach ($organization->departments as $department)
                                            <div class="department-wrapper">
                                                <a class="department" href="{{ route('organizations.department', ['slug' => $organization->slug, 'departmentSlug' => $department->slug]) }}">
                                                    <div class="department-name">{{ $department->name }}</div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div id="no-departments">
                                        @lang("tessify-core::organizations.view_no_departments")
                                    </div>  
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Projects -->
                    <div class="content-card elevation-1 mb">
                        <div class="content-card__content">
                            <h3 class="content-subtitle">@lang("tessify-core::organizations.view_projects")</h3>
                            <div id="ministry-projects">
                                @if ($organization->projects->count())
                                    <div id="projects">
                                        @foreach ($organization->projects as $project)
                                            <div class="project-wrapper">
                                                <a class="project" href="{{ route('projects.view', $project->slug) }}">
                                                    <div class="project-title">{{ $project->title }}</div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div id="no-projects">
                                        @lang("tessify-core::organizations.view_no_projects")
                                    </div>  
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tasks -->
                    <div class="content-card elevation-1">
                        <div class="content-card__content">
                            <h3 class="content-subtitle">@lang("tessify-core::organizations.view_tasks")</h3>
                            <div id="ministry-tasks">
                                @if ($organization->tasks->count())
                                    <div id="tasks">
                                        @foreach ($organization->tasks as $task)
                                            <div class="task-wrapper">
                                                <a class="task" href="{{ route('tasks.view', $task->slug) }}">
                                                    <div class="task-title">{{ $task->title }}</div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div id="no-tasks">
                                        @lang("tessify-core::organizations.view_no_tasks")
                                    </div>  
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@stop