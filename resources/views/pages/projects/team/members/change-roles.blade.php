@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.team.change-roles", $project, $user) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 id="delete-dialog__title" class="page-title centered">
                @lang("tessify-core::projects.change_roles_title")
            </h1>
        
            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Open form -->
            <form action="{{ route('projects.team.change-roles.post', ['slug' => $project->slug, 'userSlug' => $user->slug]) }}" method="post">
                @csrf

                <!-- Form -->
                <project-team-member-change-roles-form
                    :member="{{ $member->toJson() }}"
                    :roles="{{ $roles->toJson() }}"
                    :project="{{ $project->toJson() }}"
                    project-text="@lang('tessify-core::projects.change_roles_project')"
                    user-text="@lang('tessify-core::projects.change_roles_user')"
                    role-text="@lang('tessify-core::projects.change_roles_role')"
                    select-role-text="@lang('tessify-core::projects.change_roles_select_role')"
                    no-roles-text="@lang('tessify-core::projects.change_roles_no_roles_available')"
                    back-href="{{ route('projects.team.view', $project->slug) }}"
                    back-text="@lang('tessify-core::general.go_back')"
                    submit-text="@lang('tessify-core::general.save_changes')"
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}">
                </project-team-member-change-roles-form>

            </form>

        </div>
    </div>
@stop