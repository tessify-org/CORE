@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.team.applications.view", $project, $application) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::projects.view_application_title")</h1>
            
            <!-- Application -->
            <div id="team-member-application__wrapper">
                
                <!-- Feedback -->
                @include("tessify-core::partials.feedback")

                <!-- Content -->
                <div id="team-member-application" class="elevation-1">

                    <!-- Details -->
                    <div class="details">
                        <div class="detail">
                            <div class="key">ID</div>
                            <div class="val">{{ $application->id }}</div>
                        </div>
                        <div class="detail">
                            <div class="key">UUID</div>
                            <div class="val">{{ $application->uuid }}</div>
                        </div>
                        <div class="detail">
                            <div class="key">User</div>
                            <div class="val">
                                <a href="{{ route('profile', $application->user->slug) }}">
                                    {{ $application->user->formattedName }}
                                </a>
                            </div>
                        </div>
                        <div class="detail">
                            <div class="key">Processed</div>
                            <div class="val">
                                @if ($application->processed)
                                    @lang("tessify-core::general.yes")
                                @else
                                    @lang("tessify-core::general.no")
                                @endif
                            </div>
                        </div>
                        <div class="detail">
                            <div class="key">Status</div>
                            <div class="val">
                                @if ($application->processed)
                                    @if ($application->accepted)
                                        @lang("tessify-core::general.accepted")
                                    @else
                                        @lang("tessify-core::general.rejected")
                                    @endif
                                @else
                                    @lang("tessify-core::general.pending")
                                @endif
                            </div>
                        </div>
                        <div class="detail">
                            <div class="key">Role</div>
                            <div class="val">
                                {{ $application->teamRole->name }}
                            </div>
                        </div>
                        <div class="detail">
                            <div class="key">Motivation</div>
                            <div class="val">
                                {{ $application->motivation }}
                            </div>
                        </div>
                        <div class="detail">
                            <div class="key">@lang("tessify-core::general.created_at")</div>
                            <div class="val">
                                {{ $application->created_at }}
                            </div>
                        </div>
                        <div class="detail">
                            <div class="key">@lang("tessify-core::general.updated_at")</div>
                            <div class="val">
                                {{ $application->updated_at }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div id="team-member-application__footer">
                    <!-- Manage application -->
                    @can("manage-team-member-applications", $project)
                        <div id="team-member-application__footer-left">
                            @if ($application->processed)
                                <!-- Reopen button -->
                                <v-btn depressed href="{{ route('projects.team.applications.reopen', ['slug' => $project->slug, 'uuid' => $application->uuid]) }}">
                                    <i class="fas fa-redo"></i>
                                    Heropenen
                                </v-btn>
                            @else
                                <!-- Deny button -->
                                <v-btn depressed dark color="red" href="{{ route('projects.team.applications.reject', ['slug' => $project->slug, 'uuid' => $application->uuid]) }}">
                                    <i class="far fa-thumbs-down"></i>
                                    @lang("tessify-core::general.reject")
                                </v-btn>
                                <!-- Accept button -->
                                <v-btn depressed color="success" href="{{ route('projects.team.applications.accept', ['slug' => $project->slug, 'uuid' => $application->uuid]) }}">
                                    <i class="far fa-thumbs-up"></i>
                                    @lang("tessify-core::general.accept")
                                </v-btn>
                            @endif
                        </div>
                    @endcan
                    <!-- Actions -->
                    @can("manage-team-member-application", $application)
                        <div id="team-member-application__footer-right">
                            <!-- Edit button -->
                            <v-btn depressed color="warning" href="{{ route('projects.team.applications.edit', ['slug' => $project->slug, 'uuid' => $application->uuid]) }}">
                                <i class="fas fa-edit"></i>
                                @lang("tessify-core::general.edit")
                            </v-btn>
                            <!-- Delete button -->
                            <v-btn depressed dark color="red" href="{{ route('projects.team.applications.delete', ['slug' => $project->slug, 'uuid' => $application->uuid]) }}">
                                <i class="fas fa-trash-alt"></i>
                                @lang("tessify-core::general.delete")
                            </v-btn>
                        </div>
                    @endcan
                </div>
            </div>

        </div>
    </div>
@stop