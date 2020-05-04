@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks.view", $task) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Task page -->
            <div id="view-task">
                <aside id="view-task__sidebar">

                    <!-- Ownership -->
                    <div id="task-ownership">
                        <div id="task-ownership__title">@lang("tessify-core::tasks.view_ownership")</div>
                        <div id="task-ownership__content" class="elevation-1">

                            @if ($task->ministry)
                                <div id="ownership-ministry">
                                    <span id="ministry-icon">
                                        <i class="fas fa-chess-rook"></i>
                                    </span>
                                    <a id="ministry-link" href="{{ route('ministries.view', $task->ministry->slug) }}">
                                        {{ $task->ministry->name }}
                                    </a>
                                </div>
                                @if ($task->organization)
                                    <div id="ownership-organization">
                                        <a id="organization-link" href="{{ route('organizations.view', $task->organization->slug) }}">
                                            {{ $task->organization->name }}
                                        </a>
                                    </div>
                                @endif
                                
                                @if ($task->organizationDepartment)
                                    <div id="ownership-department">
                                        <a id="department-link" href="#">
                                            {{ $task->organizationDepartment->name }}
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div id="ownership-author">
                                    <a href="{{ route('profile', $task->author->slug) }}" id="author">
                                        <span id="author-avatar" style="background-image: url({{ asset($task->author->avatar_url) }})"></span>
                                        <span id="author-name">{{ $task->author->formatted_name }}</span>
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>

                    <!-- Status -->
                    <div id="task-status__wrapper">
                        <div id="task-status__title">@lang("tessify-core::tasks.view_status")</div>
                        @if ($task->status->name == "completed")
                            <div id="task-status" class="elevation-1 completed">
                                <div id="task-status__icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div id="task-status__text">
                                    {{ $task->status->label }}
                                </div>
                            </div>
                        @elseif ($task->status->name == "in_progress")
                            <div id="task-status" class="elevation-1 in_progress">
                                <div id="task-status__icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <div id="task-status__text">
                                    {{ $task->status->label }}
                                </div>
                            </div>
                        @elseif ($task->status->name == "open")
                            <div id="task-status" class="elevation-1 open">
                                <div id="task-status__icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <div id="task-status__text">
                                    {{ $task->status->label }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Signed up users -->
                    <div id="task-users">
                        <div id="task-users__title">@lang("tessify-core::tasks.view_assigned_users")</div>
                        @if (count($task->users))
                            <div id="task-users__list" class="elevation-1">
                                @foreach ($task->users as $user)
                                    <a class="task-user" href="{{ route('profile', $user->slug) }}">
                                        <span class="task-user__avatar" style="background-image: url({{ asset($user->avatar_url) }})"></span>
                                        <span class="task-user__text">
                                            {{ $user->formatted_name }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div id="task-users__no-records" class="elevation-1">
                                @lang("tessify-core::tasks.view_no_users")
                            </div>
                        @endif
                    </div>

                    <!-- Links -->
                    <!-- <div id="task-links">
                        <div id="task-links__title">@lang("tessify-core::tasks.view_links")</div>
                        <div id="task-links__links">
                            Links go here
                        </div>
                    </div> -->

                </aside>
                <main id="view-task__content">

                    <!-- Progress report -->
                    @if ($task->status->name != "completed" && $task->assigned_to_user)
                        <div id="task__report-progress" class="elevation-2">
                            <div id="report-progress__title">@lang("tessify-core::tasks.view_awaiting_progress_title")</div>
                            <div id="report-progress__text">@lang("tessify-core::tasks.view_awaiting_progress_text")</div>
                            <div id="report-progress__actions">
                                <v-btn color="primary" href="{{ route('tasks.report-progress', $task->slug) }}" depressed>
                                    <i class="fas fa-parachute-box"></i>
                                    @lang("tessify-core::tasks.view_awaiting_progress_button")
                                </v-btn>
                            </div>
                        </div>
                    @endif

                    <!-- Task information -->
                    <div id="task" class="elevation-2">

                        <!-- Header -->
                        <div id="task-header">
                            <div id="task-header__bg" style="background-image: url({{ asset($task->header_image_url) }})"></div>
                            <div id="task-header__bg-overlay"></div>
                            <div id="task-header__text">
                                @if ($task->project)
                                    <h2 id="task-project">{!! __("tessify-core::tasks.view_part_of_project", ["title" => $task->project->title]) !!}</h2>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div id="task-content">
                        
                            <!-- Content header -->
                            <div id="task-content__header">
                                <div id="task-content__header-left">
                                
                                    <!-- Title -->
                                    <h1 id="task-title">{{ $task->title }}</h1>

                                    <!-- Tags -->
                                    @if (count($task->tags))
                                        <div id="task-tags" class="tags">
                                            @foreach ($task->tags as $tag)
                                                <div class="tag-wrapper">
                                                    <div class="tag">
                                                        {{ $tag->name }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Details -->
                                    <div id="task-details">
                                        <!-- Complexity --> 
                                        <div class="task-detail">
                                            <div class="task-detail__key">@lang("tessify-core::tasks.view_complexity")</div>
                                            <div class="task-detail__val">{{ $task->complexity }}/10</div>
                                        </div>
                                        <!-- Estimated hours --> 
                                        <div class="task-detail">
                                            <div class="task-detail__key">@lang("tessify-core::tasks.view_estimated_hours")</div>
                                            <div class="task-detail__val">{{ $task->estimated_hours }} @lang("tessify-core::tasks.view_hours")</div>
                                        </div>
                                        <!-- Number of available positions -->
                                        <div class="task-detail">
                                            <div class="task-detail__key">@lang("tessify-core::tasks.view_number_positions")</div>
                                            @if ($task->num_positions == 1)
                                                <div class="task-detail__val">1 @lang("tessify-core::tasks.view_position")</div>
                                            @else
                                                <div class="task-detail__val">{{ $task->num_positions }} @lang("tessify-core::tasks.view_positions")</div>
                                            @endif
                                        </div>
                                        <!-- Urgency -->
                                        <div class="task-detail">
                                            <div class="task-detail__key">@lang("tessify-core::tasks.view_urgency")</div>
                                            <div class="task-detail__val">
                                                @if ($task->urgency == 1)
                                                    @lang("tessify-core::general.urgency_low")
                                                @elseif ($task->urgency == 2)
                                                    @lang("tessify-core::general.urgency_medium")
                                                @elseif ($task->urgency == 3)
                                                    @lang("tessify-core::general.urgency_high")
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="task-content__header-right">
                                
                                    <!-- Join & Leave -->
                                    <div id="primary-action">
                                        
                                        <!-- Completed -->
                                        @if ($task->status->name == "completed")

                                            <!-- Disabled join button -->
                                            <v-tooltip top>
                                                <template v-slot:activator="{ on }">
                                                    <v-btn color="primary" depressed block disabled v-on="on">
                                                        <i class="far fa-thumbs-up"></i>
                                                        @lang("tessify-core::tasks.view_cta_open_button")
                                                    </v-btn>
                                                </template>
                                                <span>@lang("tessify-core::tasks.view_join_disabled_completed")</span>
                                            </v-tooltip>

                                        <!-- Not completed -->
                                        @else

                                            <!-- Assigned to the user -->
                                            @if ($task->assigned_to_user)

                                                <!-- Leave button -->
                                                <v-btn color="red" href="{{ route('tasks.abandon', $task->slug) }}" depressed block dark>
                                                    <i class="fas fa-door-open"></i>
                                                    @lang("tessify-core::tasks.view_leave")
                                                </v-btn>

                                            <!-- Not assigned to the user & there are available slots -->
                                            @elseif ($task->has_available_slots)
                                                
                                                <!-- Join button -->
                                                <v-btn color="primary" href="{{ route('tasks.assign-to-me', $task->slug) }}" depressed block>
                                                    <i class="far fa-thumbs-up"></i>
                                                    @lang("tessify-core::tasks.view_join")
                                                </v-btn>

                                            <!-- Not assigned & no available slots -->
                                            @else

                                                <!-- Disabled join button -->
                                                <v-tooltip top>
                                                    <template v-slot:activator="{ on }">
                                                        <div v-on="on">
                                                            <v-btn color="primary" depressed block disabled>
                                                                <i class="far fa-thumbs-up"></i>
                                                                @lang("tessify-core::tasks.view_cta_open_button")
                                                            </v-btn>
                                                        </div>
                                                    </template>
                                                    <span>@lang("tessify-core::tasks.view_join_disabled_no_positions")</span>
                                                </v-tooltip>

                                            @endif

                                        @endif

                                    </div>

                                    <!-- Follow & Invite -->
                                    <div id="secondary-actions">
                                        <div class="secondary-action">
                                            @if (!Auth::user()->hasSubscribed($task))
                                                <!-- Follow button -->
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on }">
                                                        <v-btn href="{{ route('tasks.subscribe', ['slug' => $task->slug]) }}" class="icon-only" small depressed v-on="on">
                                                            <i class="far fa-eye"></i>
                                                        </v-btn>
                                                    </template>
                                                    <span>@lang("tessify-core::tasks.view_subscribe")</span>
                                                </v-tooltip>
                                            @else
                                                <!-- Unfollow button -->
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on }">
                                                        <v-btn href="{{ route('tasks.unsubscribe', ['slug' => $task->slug]) }}" class="icon-only" small depressed v-on="on">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </v-btn>
                                                    </template>
                                                    <span>@lang("tessify-core::tasks.view_unsubscribe")</span>
                                                </v-tooltip>
                                            @endif
                                        </div>
                                        <div class="secondary-action">
                                            <!-- Invite friend button -->
                                            <task-invite-button
                                                :task="{{ $task->toJson() }}"
                                                :users="{{ $users->toJson() }}"
                                                :strings="{{ $inviteButtonStrings->toJson() }}"
                                                endpoint="{{ route('tasks.invite', $task->slug) }}">
                                            </task-invite-button>
                                        </div>
                                    </div>

                                    <!-- Ask question -->
                                    <div id="ask-question">
                                        <a href="{{ route('tasks.ask-question', $task->slug) }}" id="ask-question__link">
                                            @lang("tessify-core::tasks.view_ask_question")
                                        </a>
                                    </div>

                                    <!-- Share -->
                                    <div id="share-task">
                                        <div id="share-task__text">@lang("tessify-core::tasks.view_share_task")</div>
                                        <div id="share-task__socials">
                                            <!-- Facebook -->
                                            <div class="social-wrapper">
                                                <a class="social" href="#">
                                                    <i class="fab fa-facebook-square"></i>
                                                </a>
                                            </div>
                                            <!-- Twitter -->
                                            <div class="social-wrapper">
                                                <a class="social" href="#">
                                                    <i class="fab fa-twitter-square"></i>
                                                </a>
                                            </div>
                                            <!-- LinkedIn -->
                                            <div class="social-wrapper">
                                                <a class="social" href="#">
                                                    <i class="fab fa-linkedin"></i>
                                                </a>
                                            </div>
                                            <!-- WhatsApp -->
                                            <div class="social-wrapper">
                                                <a class="social" href="#">
                                                    <i class="fab fa-whatsapp-square"></i>
                                                </a>
                                            </div>
                                            <!-- E-mail -->
                                            <div class="social-wrapper">
                                                <a class="social" href="#">
                                                    <i class="fas fa-envelope-square"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Description -->
                            <div id="task-description">
                                <div id="task-description__title">@lang("tessify-core::tasks.view_description")</div>
                                <div id="task-description__text">
                                    {!! nl2br($task->description) !!}
                                </div>
                            </div>

                            <!-- Required skills -->
                            @if (count($task->skills))
                                <div id="task-required-skills">
                                    <div id="task-required-skills__title">@lang("tessify-core::tasks.view_skills")</div>
                                    <div id="task-required-skills__list">
                                        @foreach ($task->skills as $skill)
                                            <div class="required-skill">
                                                <div class="required-skill__name">{{ $skill->name }}</div>
                                                @if (!is_null($skill->pivot->description))
                                                    <div class="required-skill__description">
                                                        {{ $skill->pivot->description }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Location -->
                            <div id="task-location">
                                <div id="task-location__title">@lang("tessify-core::tasks.view_location")</div>
                                <div id="task-location__content">

                                    <!-- Remote -->
                                    <div id="remote-work">
                                        <div id="remote-work__title">@lang("tessify-core::tasks.view_remote_work_title")</div>
                                        <div id="remote-work__description">@lang("tessify-core::tasks.view_remote_work_description")</div>
                                    </div>

                                    <!-- Google maps & address -->

                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Comments (TODO) -->

                    <!-- Controls -->
                    <div id="task-page-controls" class="page-controls">
                        <div class="page-controls__right">
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
                        </div>
                    </div>

                </main>
            </div>

        </div>
    </div>
@stop