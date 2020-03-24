@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks.view", $task) !!}
@stop

@section("content")
    <div id="task">

        <!-- Header -->
        <div id="task-header" style="background-image: url({{ $task->project ? asset($task->project->header_image_url) : '' }})">
            <div id="task-header__overlay"></div>
            <div id="task-header__content">

                <!-- Actions -->
                <div id="task-header__actions">
                    @if (!Auth::user()->hasSubscribed($task))
                        <v-btn color="primary" href="{{ route('tasks.subscribe', ['slug' => $task->slug]) }}">
                            <i class="fas fa-check-circle"></i>
                            @lang("tessify-core::tasks.view_subscribe")
                        </v-btn>
                    @else
                        <v-btn dark color="red" href="{{ route('tasks.unsubscribe', ['slug' => $task->slug]) }}">
                            <i class="fas fa-times-circle"></i>
                            @lang("tessify-core::tasks.view_unsubscribe")
                        </v-btn>
                    @endif
                </div>

                <!-- Text -->
                <div id="task-header__text">
                    <!-- Header title -->
                    <h1 id="task-header__title">@lang("tessify-core::tasks.view_title")</h1>
                    <!-- Header subtitle -->
                    @if ($task->project)
                        <h2 id="task-header__subtitle">{{ $task->project->title }}</h2>
                    @endif
                </div>

            </div>
        </div>

        <!-- CTA section -->
        <div id="task-cta__wrapper">
            <div id="task-cta" class="elevation-1">
                <!-- Completed -->
                @if ($task->status->name == "completed")
                    <div id="task-cta__title">Completed</div>
                    <div id="task-cta__text">Deze taak is voltooid!</div>
                @else
                    <!-- Assigned user -->
                    @if ($task->is_assigned)
                        <!-- Has outstanding report(s) -->
                        @if ($task->has_outstanding_reports)
                            <!-- Has unread review -->
                            @if ($task->has_unread_reviews)
                                <div id="task-cta__title">Report was reviewed!</div>
                                <div id="task-cta__button">
                                    <v-btn color="primary" href="{{ route('tasks.progress-report', ['slug' => $task->slug, 'uuid' => $task->outstanding_reports[0]->uuid]) }}" depressed>
                                        Bekijk progress report
                                    </v-btn>
                                </div>
                            <!-- Awaiting review -->
                            @else
                                <div id="task-cta__title">Report awaiting review</div>
                                <div id="task-cta__button">
                                    <v-btn color="primary" href="{{ route('tasks.progress-report', ['slug' => $task->slug, 'uuid' => $task->outstanding_reports[0]->uuid]) }}" depressed>
                                        Bekijk progress report
                                    </v-btn>
                                </div>
                            @endif
                        <!-- No outstanding reports -->
                        @else
                            <div id="task-cta__title">How are you doing? Anything to report?</div>
                            <div id="task-cta__button">
                                <v-btn color="primary" href="{{ route('tasks.report-progress', ['slug' => $task->slug]) }}" depressed>
                                    Report progress
                                </v-btn>
                            </div>
                        @endif
                        <!-- Leave task -->
                        <div id="task-cta__link">
                            <a href="{{ route('tasks.abandon', ['slug' => $task->slug]) }}">
                                @lang("tessify-core::tasks.view_abandon")
                            </a>
                        </div>
                    <!-- Owner -->
                    @elseif ($task->is_owner)
                        <!-- Open positions -->
                        @if ($task->is_open)
                            <div id="task-cta__title">Now we wait</div>
                            <div id="task-cta__text">Waiting for people to fill the available positions</div>
                        <!-- Positions filled -->
                        @else
                            <!-- Outstanding reports -->
                            @if ($task->has_outstanding_reports)
                                <div id="task-cta__title">Outstanding reports</div>
                                <div id="task-cta__button">
                                    <v-btn color="primary" href="{{ route('tasks.progress-report', ['slug' => $task->slug, 'uuid' => $task->outstanding_reports[0]->uuid]) }}" depressed>
                                        View progress report
                                    </v-btn>
                                </div>
                            <!-- Waiting for progress report -->
                            @else
                                <div id="task-cta__title">Now we wait</div>
                                <div id="task-cta__text">Waiting for assigned users to complete the task</div>
                            @endif
                        @endif
                    <!-- Guest user -->
                    @else
                        <!-- Open positions -->
                        @if ($task->is_open)
                            <div id="task-cta__title">{{ $task->num_open_positions }} open posities voor dit werkpakket!</div>
                            <div id="task-cta__button">
                                <v-btn color="primary" href="{{ route('tasks.assign-to-me', ['slug' => $task->slug]) }}" depressed>
                                    Schrijf je in
                                </v-btn>
                            </div>
                        <!-- Closed positions -->
                        @else
                            <div id="task-cta__title">Alle posities zijn vervuld</div>
                            <div id="task-cta__button">
                                X & Y werken zijn hiermee aan de slag
                            </div>
                        @endif
                    @endif
                @endif
            </div>
        </div>

        <!-- Content -->
        <div id="task-content" class="content-section__wrapper">
            <div class="content-section">
                
                <!-- Feedback -->
                @include("tessify-core::partials.feedback")

                <!-- Columns -->
                <div id="task-columns">
                    <div id="task-columns__left">
                        
                        <div class="content-box elevation-1">
                            <!-- Description -->
                            <div id="task-description">
                                <div id="task-description__label">@lang("tessify-core::tasks.view_description")</div>
                                <div id="task-description__text">{{ $task->description }}</div>
                            </div>
                            <!-- Required skills -->
                            @if (count($task->skills))
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
                        
                        <!-- Author -->
                        <div class="content-box elevation-1">
                            <h3 class="content-subtitle">Author</h3>
                            <user-pill dark :user="{{ $task->author->toJson() }}"></user-pill>
                        </div>

                        <!-- Details -->
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
                                <v-btn color="warning" href="{{ route('tasks.edit', ['slug' => $task->slug]) }}">
                                    <i class="fas fa-edit"></i>
                                    @lang("tessify-core::general.edit")
                                </v-btn>
                            @endcan
                            @can("delete", $task)
                                <v-btn color="red" dark href="{{ route('tasks.delete', ['slug' => $task->slug]) }}">
                                    <i class="fas fa-trash-alt"></i>
                                    @lang("tessify-core::general.delete")
                                </v-btn>
                            @endcan
                        </div>
                    @endcanany
                    @canany(["assign-to-self", "abandon"], $task)
                        <div class="form-controls__right">
                            @can("assign-to-self", $task)
                                <v-btn color="primary" href="{{ route('tasks.assign-to-me', ['slug' => $task->slug]) }}">
                                    <i class="fas fa-user-plus"></i>
                                    @lang("tessify-core::tasks.view_assign_to_self")
                                </v-btn>
                            @endcan
                            @can("abandon", $task)
                                <v-btn color="red" dark href="{{ route('tasks.abandon', ['slug' => $task->slug]) }}">
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