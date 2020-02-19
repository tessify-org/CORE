@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.team.roles.create", $project) !!}
@stop

@section("content")
    <!-- Content -->
    <div id="apply-for-project" class="content-section__wrapper">
        <div class="content-section">

            <h1 id="delete-dialog__title" class="page-title centered">
                @lang("tessify-core::projects.create_role_title")
            </h1>

            <form action="{{ route('projects.team.roles.create.post', $project->slug) }}" method="post">
                @csrf
                
                <project-team-role-form
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    name-text="@lang('tessify-core::projects.create_role_name')"
                    description-text="@lang('tessify-core::projects.create_role_description')"
                    positions-text="@lang('tessify-core::projects.create_role_positions')"
                    back-href="{{ route('projects.team.view', $project->slug) }}"
                    back-text="@lang('tessify-core::projects.create_role_back')"
                    submit-text="@lang('tessify-core::projects.create_role_submit')">
                </project-team-role-form>
                
            </form>

        </div>
    </div>
@stop