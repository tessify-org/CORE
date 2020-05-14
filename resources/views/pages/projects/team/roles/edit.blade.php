@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.team.roles.edit", $project, $teamRole) !!}
@stop

@section("content")
    <!-- Content -->
    <div id="apply-for-project" class="content-section__wrapper">
        <div class="content-section">

            <h1 id="delete-dialog__title" class="page-title centered">
                @lang("tessify-core::projects.edit_role_title")
            </h1>

            <form action="{{ route('projects.team.roles.create.post', $project->slug) }}" method="post">
                @csrf
                
                <project-team-role-form
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    :role="{{ $teamRole->toJson() }}"
                    name-text="@lang('tessify-core::projects.edit_role_name')"
                    description-text="@lang('tessify-core::projects.edit_role_description')"
                    positions-text="@lang('tessify-core::projects.edit_role_positions')"
                    back-href="{{ route('projects.team.view', $project->slug) }}"
                    back-text="@lang('tessify-core::projects.edit_role_back')"
                    submit-text="@lang('tessify-core::projects.edit_role_submit')">
                </project-team-role-form>
                
            </form>

        </div>
    </div>
@stop