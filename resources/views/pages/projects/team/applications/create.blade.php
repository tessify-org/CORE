@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.team.apply", $project) !!}
@stop

@section("content")
    <!-- Content -->
    <div id="apply-for-project" class="content-section__wrapper">
        <div class="content-section">

            <h1 id="delete-dialog__title" class="page-title centered">
                @lang("tessify-core::projects.apply_title")
            </h1>

            <form action="{{ route('projects.team.apply.post', $project->slug) }}" method="post">
                @csrf
                
                <apply-for-team-form
                    :project="{{ $project->toJson() }}"
                    :roles="{{ $roles->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    back-href="{{ route('projects.team.view', $project->slug) }}"
                    back-text="@lang('tessify-core::projects.apply_back')"
                    submit-text="@lang('tessify-core::projects.apply_submit')"
                    project-text="@lang('tessify-core::projects.apply_form_project')"
                    role-text="@lang('tessify-core::projects.apply_form_role')"
                    motivation-text="@lang('tessify-core::projects.apply_form_motivation')">
                </apply-for-team-form>
                
            </form>

        </div>
    </div>
@stop