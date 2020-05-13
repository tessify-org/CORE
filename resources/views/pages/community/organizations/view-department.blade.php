@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("organizations.department", $organization, $department) !!}
@stop

@section("content")
    <div id="department">
        
        <!-- Header -->
        <div id="department-header">
            <div id="department-header__overlay"></div>
            <div id="department-header__content">
                <div id="department-header__text">
                    <h1 id="department-header__title">{{ $department->name }}</h1>
                </div>
                <div id="department-header__actions">
                    <v-btn href="{{ route('organizations.view', $organization->slug) }}" color="white" outlined>
                        <i class="fas fa-arrow-left"></i>
                        @lang("tessify-core::organizations.department_back_to_organization", ["name" => $organization->name])
                    </v-btn>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div id="department-content">
            <div class="content-section__wrapper">
                <div class="content-section">

                    <!-- Department information -->
                    <div class="content-card elevation-1 mb">
                        <div class="content-card__content">
                            <h3 class="content-subtitle">@lang("tessify-core::organizations.view_details")</h3>
                            <div class="details no-padding mb-0">
                                <!-- Ministry -->
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::organizations.department_ministry")</div>
                                    <div class="val">
                                        <a href="{{ route('ministries.view', $organization->ministry->slug) }}">
                                            {{ $organization->ministry->name }}
                                        </a>
                                    </div> 
                                </div>
                                <!-- Organization -->
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::organizations.department_organization")</div>
                                    <div class="val">
                                        <a href="{{ route('ministries.view', $organization->slug) }}">
                                            {{ $organization->name }}
                                        </a>
                                    </div> 
                                </div>
                                <!-- Name -->
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::organizations.department_name")</div>
                                    <div class="val">{{ $department->name }}</div> 
                                </div>
                                <!-- Description -->
                                @if (!is_null($department->description))
                                    <div class="detail">
                                        <div class="key">@lang("tessify-core::organizations.department_description")</div>
                                        <div class="val">{{ $department->description }}</div> 
                                    </div>
                                @endif
                                <!-- Website -->
                                @if (!is_null($department->website_url))
                                    <div class="detail">
                                        <div class="key">@lang("tessify-core::organizations.department_website")</div>
                                        <div class="val">
                                            <a href="{{ $organization->website_url }}" target="_blank">
                                                {{ $department->website_url }}
                                            </a>
                                        </div> 
                                    </div>
                                @endif
                                <!-- Last updated on -->
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::organizations.view_last_update")</div>
                                    <div class="val">{{ $organization->updated_at->format("d-m-Y H:m:s") }}</div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Projects -->
                    <div class="content-card elevation-1 mb">
                        <div class="content-card__content">
                            <h3 class="content-subtitle">@lang("tessify-core::organizations.department_projects")</h3>
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
                                        @lang("tessify-core::organizations.department_no_projects")
                                    </div>  
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tasks -->
                    <div class="content-card elevation-1">
                        <div class="content-card__content">
                            <h3 class="content-subtitle">@lang("tessify-core::organizations.department_tasks")</h3>
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
                                        @lang("tessify-core::organizations.department_no_tasks")
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