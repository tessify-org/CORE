@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.tasks.view", $project, $task) !!}
@stop

@section("content")
    <div id="task">
        <div id="task-header" style="background-image: url({{ asset($project->header_image_url) }})">
            <div id="task-header__overlay"></div>
            <div id="task-header__content">
                <div id="task-header__actions">
                    @if (!Auth::user()->hasSubscribed($task))
                        <v-btn color="primary" href="{{ route('projects.tasks.subscribe', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}">
                            <i class="fas fa-check-circle"></i>
                            @lang("tessify-core::tasks.view_subscribe")
                        </v-btn>
                    @else
                        <v-btn dark color="red" href="{{ route('projects.tasks.unsubscribe', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}">
                            <i class="fas fa-times-circle"></i>
                            @lang("tessify-core::tasks.view_unsubscribe")
                        </v-btn>
                    @endif
                </div>
                <div id="task-header__text">
                    <h1 id="task-header__title">@lang("tessify-core::tasks.view_title")</h1>
                    <h2 id="task-header__subtitle">{{ $project->title }}</h2>
                </div>
            </div>
        </div>
        <div id="task-content" class="content-section__wrapper">
            <div class="content-section">
                
                <!-- Feedback -->
                @include("tessify-core::partials.feedback")

                <!-- Columns -->
                <div id="task-columns">
                    <div id="task-columns__left">
                        
                        <div class="content-box elevation-1">

                            <div id="task-description">
                                <div id="task-description__label">@lang("tessify-core::tasks.view_description")</div>
                                <div id="task-description__text">{{ $project->description }}</div>
                            </div>

                            @if ($task->skills->count())
                                <div id="task-skills">
                                    <div id="task-skills__label">@lang("tessify-core::tasks.view_skills")</div>
                                    <div id="task-skills__list">
                                        @foreach ($task->skills as $skill)
                                            <div class="task-skill">
                                                <div class="task-skill__name">{{ $skill->name }}</div>
                                                <div class="task-skill__mastery">{{ $skill->pivot->required_mastery }}/10</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>
                    <div id="task-columns__right">
                        
                        <div class="details elevation-1 mb-0">
                            <div class="detail">
                                <div class="key">@lang("tessify-core::tasks.view_status")</div>
                                <div class="val">{{ $task->status->label }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">@lang("tessify-core::tasks.view_category")</div>
                                <div class="val">{{ $task->category->name }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">@lang("tessify-core::tasks.view_seniority")</div>
                                <div class="val">{{ $task->seniority->label }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">@lang("tessify-core::tasks.view_complexity")</div>
                                <div class="val">{{ $task->complexity }} / 10</div>
                            </div>
                            <div class="detail">
                                <div class="key">@lang("tessify-core::tasks.view_estimated_hours")</div>
                                <div class="val">{{ $task->estimated_hours }}</div>
                            </div>
                            @if ($task->status->name == "completed")
                                <div class="detail">
                                    <div class="key">@lang("tessify-core::tasks.view_realized_hours")</div>
                                    <div class="val">{{ $task->realized_hours }}</div>
                                </div>
                            @endif
                            <div class="detail">
                                <div class="key">@lang("tessify-core::tasks.view_number_positions")</div>
                                <div class="val">{{ $task->num_positions }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">@lang("tessify-core::tasks.view_assigned_users")</div>
                                <div class="val">
                                    @if ($task->users->count())
                                        <ul>
                                            @foreach ($task->users as $user)
                                                <li>{{ $user->formattedName }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        @lang("tessify-core::tasks.view_no_assigned_users")
                                    @endif
                                </div>
                            </div>
                            <div class="detail">
                                <div class="key">@lang("tessify-core::tasks.view_created_at")</div>
                                <div class="val">{{ $task->created_at->format("d-m-Y") }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">@lang("tessify-core::tasks.view_updated_at")</div>
                                <div class="val">{{ $task->updated_at->format("d-m-Y") }}</div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Controls -->
                <div class="form-controls">
                    @canany(["update", "delete"], $task)
                        <div class="form-controls__left">
                            @can("update", $task)
                                <v-btn color="warning" href="{{ route('projects.tasks.edit', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}">
                                    <i class="fas fa-edit"></i>
                                    @lang("tessify-core::general.edit")
                                </v-btn>
                            @endcan
                            @can("delete", $task)
                                <v-btn color="red" dark href="{{ route('projects.tasks.delete', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}">
                                    <i class="fas fa-trash-alt"></i>
                                    @lang("tessify-core::general.delete")
                                </v-btn>
                            @endcan
                        </div>
                    @endcanany
                    @canany(["assign-to-self", "abandon"], $task)
                        <div class="form-controls__right">
                            @can("assign-to-self", $task)
                                <v-btn color="primary" href="{{ route('projects.tasks.assign-to-me', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}">
                                    <i class="fas fa-user-plus"></i>
                                    @lang("tessify-core::tasks.view_assign_to_self")
                                </v-btn>
                            @endcan
                            @can("abandon", $task)
                                <v-btn color="red" dark href="{{ route('projects.tasks.abandon', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}">
                                    <i class="fas fa-user-minus"></i>
                                    @lang("tessify-core::tasks.view_abandon")
                                </v-btn>
                            @endcan
                        </div>
                    @endcanany
                </div>
    
            </div>
        </div>

    </div>
@stop