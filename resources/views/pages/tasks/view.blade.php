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
                @if ($task->status->name == "completed")

                    <!-- Completed -->
                    <div id="task-cta__title">@lang("tessify-core::tasks.view_cta_completed_title")</div>
                    <div id="task-cta__text">@lang("tessify-core::tasks.view_cta_completed_text")</div>
                    <div id="task-cta__image" style="background-image: url({{ asset('storage/images/undraw/completed.svg') }})"></div>
                    
                @else

                    <!-- Assigned user -->
                    @if ($task->is_assigned)

                        <!-- Has outstanding report(s) -->
                        @if ($task->has_outstanding_reports)

                            @if ($task->has_unread_reviews)

                                <!-- Has unread review -->
                                <div id="task-cta__title">@lang("tessify-core::tasks.view_cta_reviewed_title")</div>
                                <div id="task-cta__text">@lang("tessify-core::tasks.view_cta_reviewed_text")</div>
                                <div id="task-cta__button">
                                    <v-btn color="primary" href="{{ route('tasks.progress-report', ['slug' => $task->slug, 'uuid' => $task->outstanding_reports[0]->uuid]) }}" depressed>
                                        @lang("tessify-core::tasks.view_cta_reviewed_button")
                                    </v-btn>
                                </div>
                                <div id="task-cta__image" style="background-image: url({{ asset('storage/images/undraw/certifications.svg') }})"></div>

                            @else

                                <!-- Awaiting review -->
                                <div id="task-cta__title">@lang("tessify-core::tasks.view_cta_awaiting_review_title")</div>
                                <div id="task-cta__text">@lang("tessify-core::tasks.view_cta_awaiting_review_text")</div>
                                <div id="task-cta__button">
                                    <v-btn color="primary" href="{{ route('tasks.progress-report', ['slug' => $task->slug, 'uuid' => $task->outstanding_reports[0]->uuid]) }}" depressed>
                                        Bekijk progress report
                                    </v-btn>
                                </div>
                                <div id="task-cta__image" style="background-image: url({{ asset('storage/images/undraw/season_change.svg') }}); right: -60px; bottom: -67px;"></div>

                            @endif

                        @else

                            <!-- No outstanding reports -->
                            <div id="task-cta__title">@lang("tessify-core::tasks.view_cta_awaiting_progress_title")</div>
                            <div id="task-cta__text">@lang("tessify-core::tasks.view_cta_awaiting_progress_text")</div>
                            <div id="task-cta__button">
                                <v-btn color="primary" href="{{ route('tasks.report-progress', ['slug' => $task->slug]) }}" depressed>
                                    @lang("tessify-core::tasks.view_cta_awaiting_progress_button")
                                </v-btn>
                            </div>
                            <div id="task-cta__image" style="background-image: url({{ asset('storage/images/undraw/confirmation.svg') }}); right: -25px;"></div>

                        @endif

                        <!-- Leave task -->
                        <div id="task-cta__link">
                            <a href="{{ route('tasks.abandon', ['slug' => $task->slug]) }}">
                                @lang("tessify-core::tasks.view_abandon")
                            </a>
                        </div>

                    <!-- Owner -->
                    @elseif ($task->is_owner)

                        <!-- Positions are open -->
                        @if ($task->is_open)

                            <!-- Open positions -->
                            <div id="task-cta__title">@lang("tessify-core::tasks.view_cta_open_title")</div>
                            <div id="task-cta__text">
                                @if ($task->num_open_positions == 1)
                                    @lang("tessify-core::tasks.view_cta_open_text_singular")
                                @else
                                    @lang("tessify-core::tasks.view_cta_open_text_multiple", ["positions" => $task->num_open_positions])
                                @endif
                            </div>
                            @can("assign-to-self", $task)
                                <div id="task-cta__button">
                                    <v-btn color="primary" href="{{ route('tasks.assign-to-me', $task->slug) }}">
                                        @lang("tessify-core::tasks.view_cta_open_button")
                                    </v-btn>
                                </div>
                            @endcan
                            <div id="task-cta__image" style="background-image: url({{ asset('storage/images/undraw/in_love.svg') }})"></div>

                        <!-- Position have been filled -->
                        @else

                            <!-- Has outstanding reports -->
                            @if ($task->has_outstanding_reports)

                                <!-- Outstanding reports -->
                                <div id="task-cta__title">@lang("tessify-core::tasks.view_cta_outstanding_reports_title")</div>
                                <div id="task-cta__text">@lang("tessify-core::tasks.view_cta_outstanding_reports_text")
                                <div id="task-cta__button">
                                    <v-btn color="primary" href="{{ route('tasks.progress-report', ['slug' => $task->slug, 'uuid' => $task->outstanding_reports[0]->uuid]) }}" depressed>
                                        @lang("tessify-core::tasks.view_cta_outstanding_reports_button")
                                    </v-btn>
                                </div>
                                <div id="task-cta__image" style="background-image: url({{ asset('storage/images/undraw/like_dislike.svg') }})"></div>

                            <!-- Has no outstanding reports -->
                            @else

                                <!-- Waiting for progress report -->
                                <div id="task-cta__title">@lang("tessify-core::tasks.view_cta_awaiting_reports_title")</div>
                                <div id="task-cta__text">@lang("tessify-core::tasks.view_cta_awaiting_reports_text")</div>
                                <div id="task-cta__image" style="background-image: url({{ asset('storage/images/undraw/season_change.svg') }}); right: -60px; bottom: -67px;"></div>

                            @endif

                        @endif

                    <!-- Guest user -->
                    @else

                        <!-- Task has open positions -->
                        @if ($task->is_open)

                            <!-- Number of open positions -->
                            <div id="task-cta__title">@lang("tessify-core::tasks.view_cta_open_title")</div>
                            <div id="task-cta__text">
                                @if ($task->num_open_positions == 1)
                                    @lang("tessify-core::tasks.view_cta_open_text_singular")
                                @else
                                    @lang("tessify-core::tasks.view_cta_open_text_multiple", ["positions" => $task->num_open_positions])
                                @endif
                            </div>
                            @can("assign-to-self", $task)
                                <div id="task-cta__button">
                                    <v-btn color="primary" href="{{ route('tasks.assign-to-me', $task->slug) }}">
                                        @lang("tessify-core::tasks.view_cta_open_button")
                                    </v-btn>
                                </div>
                            @endcan
                            <div id="task-cta__image" style="background-image: url({{ asset('storage/images/undraw/in_love.svg') }})"></div>
                        
                        <!-- Task has no open positions anymore -->
                        @else

                            <!-- Closed positions -->
                            <div id="task-cta__title">@lang("tessify-core::tasks.view_cta_positions_filled_title")</div>
                            <div id="task-cta__text">@lang("tessify-core::tasks.view_cta_positions_filled_text")</div>
                            <div id="task-cta__assignees-label">@lang("tessify-core::tasks.view_cta_positions_filled_assignees")</div>
                            <div id="task-cta__assignees">
                                
                            </div>
                            <div id="task-cta__image" style="background-image:  url({{ asset('storage/images/undraw/group_selfie.svg') }})"></div>

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