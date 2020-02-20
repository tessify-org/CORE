@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.team.view", $project) !!}
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

                <!-- Team members -->
                <div class="content-box elevation-1">
                    <h3 class="content-subtitle">
                        @lang("tessify-core::projects.view_team_team_members")
                    </h3>
                    @if ($project->teamMembers->count())
                        <div id="team-members">
                            @foreach ($project->teamMembers as $teamMember)
                                <div class="team-member__wrapper">
                                    <div class="team-member">
                                        <div class="team-member__avatar-wrapper">
                                            <div class="team-member__avatar" style="background-image: url({{ asset($teamMember->user->avatar_url) }})"></div>
                                        </div>
                                        <div class="team-member__text-wrapper">
                                            <div class="team-member__user">{{ $teamMember->user->formattedName }}</div>
                                            <div class="team-member__title">@lang("tessify-core::general.as") <span>{{ $teamMember->title }}</span></div>
                                        </div>
                                        <div class="team-member__actions">
                                            <v-btn depressed small href="{{ route('profile', $teamMember->user->slug) }}">
                                                Bekijk profiel
                                            </v-btn>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div id="no-team-members">
                            @lang("tessify-core::projects.view_team_no_team_members")
                        </div>
                    @endif
                </div>

                <!-- Outstanding roles -->
                <div class="content-box elevation-1">
                    <h3 class="content-subtitle">@lang('tessify-core::projects.view_team_outstanding_roles')</h3>
                    <p>@lang('tessify-core::projects.view_team_outstanding_roles_intro')</p>
                    @if ($outstandingRoles->count())
                        <div id="team-roles">
                            @foreach ($outstandingRoles as $teamRole)
                                <div class="team-role__wrapper">
                                    <div class="team-role">
                                        <!-- Text -->
                                        <div class="team-role__text-wrapper">
                                            <!-- Role name -->
                                            <div class="role-name">{{ $teamRole->name }}</div>
                                            <!-- Role skills -->
                                            @if ($teamRole->skills->count())
                                                <div class="role-skills__wrapper">
                                                    <div class="role-skills">
                                                        @foreach ($teamRole->skills as $skill)
                                                            <div class="role-skill">{{ $skill->name }}</div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            <!-- Role description -->
                                            <div class="role-description">{{ $teamRole->description }}</div>
                                        </div>
                                        <!-- Actions -->
                                        @can("manage-team-roles", $project)
                                            <div class="team-role__actions">
                                                <!-- Assign to me -->
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on }">
                                                        <a class="team-role__action" href="{{ route('projects.team.roles.assign-to-me', ['slug' => $project->slug, 'roleSlug' => $teamRole->slug]) }}" v-on="on">
                                                            <i class="fas fa-user-plus"></i>
                                                        </a>
                                                    </template>
                                                    <span>@lang("tessify-core::projects.view_team_assign_to_me")</span>
                                                </v-tooltip>
                                                <!-- Update -->
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on }">
                                                        <a v-on="on" class="team-role__action" href="{{ route('projects.team.roles.edit', ['slug' => $project->slug, 'roleSlug' => $teamRole->slug]) }}">
                                                            <i class="fas fa-pen-square"></i>
                                                        </a>
                                                    </template>
                                                    <span>@lang("tessify-core::projects.view_team_role_edit")</span>
                                                </v-tooltip>
                                                <!-- Delete -->
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on }">
                                                        <a v-on="on" class="team-role__action" href="{{ route('projects.team.roles.delete', ['slug' => $project->slug, 'roleSlug' => $teamRole->slug]) }}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </template>
                                                    <span>@lang("tessify-core::projects.view_team_role_delete")</span>
                                                </v-tooltip>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="team-roles__actions">
                            @can("apply-for-team", $project)
                                <div id="team-roles__actions-left">
                                    <v-btn large depressed color="primary" href="{{ route('projects.team.apply', $project->slug) }}">
                                        <i class="fas fa-user-plus"></i>
                                        @lang("tessify-core::projects.view_team_apply")
                                    </v-btn>
                                </div>
                            @endcan
                            @can("manage-team-roles", $project)
                                <div id="team-roles__actions-right">
                                    <v-btn large depressed color="primary" href="{{ route('projects.team.roles.create', $project->slug) }}">
                                        <i class="fas fa-plus"></i>
                                        @lang("tessify-core::projects.view_team_add_roles")
                                    </v-btn>
                                </div>
                            @endcan
                        </div>
                    @else
                        <div id="no-team-roles">@lang("tessify-core::projects.view_team_no_roles")</div>
                    @endif
                </div>

            </div>
        </div>

    </div>
@stop