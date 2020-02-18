@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.view", $project) !!}
@stop

@section("content")
    <div id="project">

        <!-- Header -->
        <div id="project-header" style="background-image: url({{ asset($project->header_image_url) }});">
            <div id="project-header__overlay"></div>
            <div id="project-header__content" class="content-section">

                <!-- Feedback -->
                @include("tessify-core::partials.feedback")

                <div id="project-header__text">
                    <h1 id="project-header__title">{{ $project->title }}</h1>
                    <h2 id="project-header__slogan">{{ $project->slogan }}</h2>
                </div>

            </div>
        </div>

        <!-- Content -->
        <div id="project-content" class="content-section__wrapper">
            <div class="content-section">

                <!-- Navigation -->
                @include("tessify-core::partials.projects.navigation", [
                    "page" => "team",
                    "project" => $project,    
                ])

                <!-- Project team roles & members -->
                <div id="project-members" class="content-box elevation-1">
                    
                    <h3 class="content-subtitle">Team rollen</h3>
                    
                    <div id="project-team">
                        @if ($project->teamRoles->count())
                            <div id="team-roles">
                                @foreach ($project->teamRoles as $teamRole)
                                    <div class="team-role__wrapper">
                                        <div class="team-role">
                                            <!-- Avatar -->
                                            <div class="team-role__avatar-wrapper">
                                                @if ($teamRole->teamMember)
                                                    <div class="team-role__avatar" style="background-image: url({{ asset($teamRole->teamMember->user->avatar_url) }})"></div>
                                                @else
                                                    <div class="team-role__avatar">
                                                        Open!<br>Meld je aan
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- Role -->
                                            <div class="team-role__text-wrapper">
                                                <div class="role-name">{{ $teamRole->name }}</div>
                                                @if ($teamRole->skills->count())
                                                    <div class="role-skills__wrapper">
                                                        <div class="role-skills">
                                                            @foreach ($teamRole->skills as $skill)
                                                                <div class="role-skill">
                                                                    {{ $skill->name }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- Assigned member -->
                                            @if ($teamRole->teamMember)
                                                <div class="team-role__member">
                                                    <div class="team-role__member-label">Vervuld door:</div>
                                                    <user-pill
                                                        :user="{{ $teamRole->teamMember->user->toJson() }}">
                                                    </user-pill>
                                                </div>
                                            @endif
                                            <!-- Actions -->
                                            <div class="team-role__actions">
                                                <v-btn color="primary" large depressed>
                                                    Meld je aan!
                                                </v-btn>
                                            </div>
                                        </div>
                                        @if ($teamRole->teamMember)
                                            <div class="team-role__footer">
                                                <div class="team-role__footer-left">
            
                                                </div>
                                                <div class="team-role__footer-right">
                                                    <v-btn small color="red" dark depressed>
                                                        Team lid afzetten
                                                    </v-btn>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div id="no-team-roles">
                                Er zijn nog geen rollen gedefineert.
                            </div>
                        @endif
                    </div>
                    
                </div>

            </div>
        </div>

    </div>
@stop