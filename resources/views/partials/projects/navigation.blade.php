<div id="project-navigation__wrapper">
    <nav id="project-navigation" class="elevation-1">
        <ul>
            <!-- Information -->
            <li @if($page == 'info') class="active" @endif>
                <a href="{{ route('projects.view', $project->slug) }}">
                    Project informatie
                </a>
            </li>
            <!-- Team members -->
            <li @if($page == 'team') class="active" @endif>
                <a href="{{ route('projects.view.team', $project->slug) }}">
                    Het team
                </a>
            </li>
            <!-- Team applications -->
            <li @if($page == 'team-applications') class="active" @endif>
                <a href="{{ route('projects.view.team-applications', $project->slug) }}">
                    Aanmeldingen
                </a>
            </li>
        </ul>
    </nav>
</div>