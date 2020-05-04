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
<div id="task-links">
    <div id="task-links__title">@lang("tessify-core::tasks.view_links")</div>
    <div id="task-links__links" class="elevation-1">
        <!-- Reviews -->
        <a class="task-link @if (isset($page) && $page === 'reviews') selected @endif" href="{{ route('tasks.reviews', $task->slug) }}">
            <span class="task-link__icon">
                <i class="fas fa-scroll"></i>
            </span>
            <span class="task-link__text">
                @lang("tessify-core::tasks.view_link_reviews") ({{ $task->num_reviews }})
            </span>
        </a>
        <!-- Comments -->
        <a class="task-link @if (isset($page) && $page == 'comments') selected @endif" href="{{ route('tasks.comments', $task->slug) }}">
            <span class="task-link__icon">
                <i class="far fa-comments"></i>
            </span>
            <span class="task-link__text">
                @lang("tessify-core::tasks.view_link_comments") ({{ $task->num_comments }})
            </span>
        </a>
        <!-- Progress reports -->
        <a class="task-link @if (isset($page) && $page === 'progress-reports') selected @endif" href="{{ route('tasks.progress-reports', $task->slug) }}">
            <span class="task-link__icon">
                <i class="fas fa-tasks"></i>
            </span>
            <span class="task-link__text">
                @lang("tessify-core::tasks.view_link_progress_reports") ({{ $task->num_progress_reports }})
            </span>
        </a>
        <!--
        <a class="task-link" href="#">
            <span class="task-link__icon">
            </span>
            <span class="task-link__text">
            </span>
        </a>
        -->
    </div>
</div>
