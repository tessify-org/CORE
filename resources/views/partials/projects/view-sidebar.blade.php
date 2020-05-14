<!-- Ownership -->
<div id="project-ownership">
    <div id="project-ownership__title">@lang("tessify-core::projects.view_ownership")</div>
    <div id="project-ownership__content" class="elevation-1">
        @if ($project->ministry)
            <div id="ownership-ministry">
                <span id="ministry-icon">
                    <i class="fas fa-chess-rook"></i>
                </span>
                <a id="ministry-link" href="{{ route('ministries.view', $project->ministry->slug) }}">
                    {{ $project->ministry->name }}
                </a>
            </div>
            @if ($project->organization)
                <div id="ownership-organization">
                    <a id="organization-link" href="{{ route('organizations.view', $project->organization->slug) }}">
                        {{ $project->organization->name }}
                    </a>
                </div>
            @endif
            @if ($project->organizationDepartment)
                <div id="ownership-department">
                    <a id="department-link" href="#">
                        {{ $project->organizationDepartment->name }}
                    </a>
                </div>
            @endif
        @else
            <div id="ownership-author">
                <a href="{{ route('profile', $project->author->slug) }}" id="author">
                    <span id="author-avatar" style="background-image: url({{ asset($project->author->avatar_url) }})"></span>
                    <span id="author-name">{{ $project->author->formatted_name }}</span>
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Status -->
<div id="project-status__wrapper">
    <div id="project-status__title">@lang("tessify-core::projects.view_status")</div>
    @if ($project->status->name == "closed")
        <div id="project-status" class="elevation-1 completed">
            <div id="project-status__icon">
                <i class="fas fa-check"></i>
            </div>
            <div id="project-status__text">
                {{ $project->status->label }}
            </div>
        </div>
    @elseif ($project->status->name == "open")
        <div id="project-status" class="elevation-1 open">
            <div id="project-status__icon">
                <i class="fas fa-box-open"></i>
            </div>
            <div id="project-status__text">
                {{ $project->status->label }}
            </div>
        </div>
    @endif
</div>

<!-- Signed up users -->
<div id="project-users">
    <div id="project-users__title">@lang("tessify-core::projects.view_team_members")</div>
    @if (count($project->teamMembers))
        <div id="project-users__list" class="elevation-1">
            @foreach ($project->teamMembers as $member)
                <a class="project-user" href="{{ route('profile', $member->user->slug) }}">
                    <span class="project-user__avatar" style="background-image: url({{ asset($member->user->avatar_url) }})"></span>
                    <span class="project-user__text">{{ $member->user->formatted_name }}</span>
                </a>
            @endforeach
        </div>
    @else
        <div id="project-users__no-records" class="elevation-1">
            @lang("tessify-core::projects.view_no_team_members")
        </div>
    @endif
</div>

<!-- Links -->
<div id="project-links">
    <div id="project-links__title">@lang("tessify-core::projects.view_links")</div>
    <div id="project-links__links" class="elevation-1">
        <!-- Tasks -->
        <a class="project-link @if (isset($page) && $page == 'tasks') selected @endif" href="{{ route('projects.tasks', $project->slug) }}">
            <span class="project-link__icon">
                <i class="fas fa-medkit"></i>
            </span>
            <span class="project-link__text">
                @lang("tessify-core::projects.view_link_tasks") ({{ $project->num_tasks }})
            </span>
        </a>
        <!-- Resources -->
        <a class="project-link @if (isset($page) && $page == 'resources') selected @endif" href="{{ route('projects.resources', $project->slug) }}">
            <span class="project-link__icon">
                <i class="fas fa-medkit"></i>
            </span>
            <span class="project-link__text">
                @lang("tessify-core::projects.view_link_resources") ({{ $project->num_resources }})
            </span>
        </a>
        <!-- Team members -->
        <a class="project-link @if (isset($page) && $page == 'team') selected @endif" href="{{ route('projects.team', $project->slug) }}">
            <span class="project-link__icon">
                <i class="fas fa-users"></i>
            </span>
            <span class="project-link__text">
                @lang("tessify-core::projects.view_link_team") ({{ $project->num_team_members }})
            </span>
        </a>
        <!-- Team roles -->
        <a class="project-link @if (isset($page) && $page == 'team-roles') selected @endif" href="{{ route('projects.team.roles', $project->slug) }}">
            <span class="project-link__icon">
                <i class="fas fa-user-tag"></i>
            </span>
            <span class="project-link__text">
                @lang("tessify-core::projects.view_link_roles") ({{ $project->num_team_roles }})
            </span>
        </a>
        <!-- Reviews -->
        <a class="project-link @if (isset($page) && $page === 'reviews') selected @endif" href="{{ route('projects.reviews', $project->slug) }}">
            <span class="project-link__icon">
                <i class="fas fa-scroll"></i>
            </span>
            <span class="project-link__text">
                @lang("tessify-core::projects.view_link_reviews") ({{ $project->num_reviews }})
            </span>
        </a>
        <!-- Comments -->
        <a class="project-link @if (isset($page) && $page == 'comments') selected @endif" href="{{ route('projects.comments', $project->slug) }}">
            <span class="project-link__icon">
                <i class="far fa-comments"></i>
            </span>
            <span class="project-link__text">
                @lang("tessify-core::projects.view_link_comments") ({{ $project->num_comments }})
            </span>
        </a>

        <!--
        <a class="project-link" href="#">
            <span class="project-link__icon">
            </span>
            <span class="project-link__text">
            </span>
        </a>
        -->
    </div>
</div>
