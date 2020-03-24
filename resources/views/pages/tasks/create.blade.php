@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks.create", $project) !!}
@stop

@section("content")
    <div id="apply-for-project" class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 id="delete-dialog__title" class="page-title centered">
                @lang("tessify-core::tasks.create_title")
            </h1>

            <!-- Open form -->
            <form action="{{ route('tasks.create.post') }}" method="post">
                @csrf

                <!-- Render form -->
                <task-form
                    :project="{{ is_null($project) ? json_encode(null) : $project->toJson() }}"
                    :skills="{{ $skills->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    :projects="{{ $projects->toJson() }}"
                    :categories="{{ $categories->toJson() }}"
                    :seniorities="{{ $seniorities->toJson() }}"
                    project-text="@lang('tessify-core::tasks.create_form_project')"
                    category-text="@lang('tessify-core::tasks.create_form_category')"
                    seniority-text="@lang('tessify-core::tasks.create_form_seniority')"
                    title-text="@lang('tessify-core::tasks.create_form_title')"
                    description-text="@lang('tessify-core::tasks.create_form_description')"
                    complexity-text="@lang('tessify-core::tasks.create_form_complexity')"
                    estimated-hours-text="@lang('tessify-core::tasks.create_form_estimated_hours')"
                    realized-hours-text="@lang('tessify-core::tasks.create_form_realized_hours')"
                    select-category-text="@lang('tessify-core::tasks.create_form_select_category')"
                    no-categories-text="@lang('tessify-core::tasks.create_form_no_categories')"
                    select-seniority-text="@lang('tessify-core::tasks.create_form_select_seniority')"
                    no-seniorities-text="@lang('tessify-core::tasks.create_form_no_seniorities')"
                    select-status-text="@lang('tessify-core::tasks.create_form_select_status')"
                    required-skills-text="@lang('tessify-core::tasks.create_form_required_skills')"
                    required-skills-no-records-text="@lang('tessify-core::tasks.create_form_required_skills_no_records')"
                    required-skills-add-button-text="@lang('tessify-core::tasks.create_form_required_skills_add_button')"
                    required-skills-view-title-text="@lang('tessify-core::tasks.create_form_required_skills_view_title')"
                    required-skills-view-skill-text="@lang('tessify-core::tasks.create_form_required_skills_view_skill')"
                    required-skills-view-required-mastery-text="@lang('tessify-core::tasks.create_form_required_skills_view_required_mastery')"
                    required-skills-view-description-text="@lang('tessify-core::tasks.create_form_required_skills_view_description')"
                    required-skills-add-title-text="@lang('tessify-core::tasks.create_form_required_skills_add_title')"
                    required-skills-form-skill-text="@lang('tessify-core::tasks.create_form_required_skills_form_skill')"
                    required-skills-form-required-mastery-text="@lang('tessify-core::tasks.create_form_required_skills_form_required_mastery')"
                    required-skills-form-description-text="@lang('tessify-core::tasks.create_form_required_skills_form_description')"
                    required-skills-add-cancel-text="@lang('tessify-core::tasks.create_form_required_skills_add_cancel')"
                    required-skills-add-submit-text="@lang('tessify-core::tasks.create_form_required_skills_add_submit')"
                    required-skills-edit-title-text="@lang('tessify-core::tasks.create_form_required_skills_edit_title')"
                    required-skills-edit-cancel-text="@lang('tessify-core::tasks.create_form_required_skills_edit_cancel')"
                    required-skills-edit-submit-text="@lang('tessify-core::tasks.create_form_required_skills_edit_submit')"
                    required-skills-delete-title-text="@lang('tessify-core::tasks.create_form_required_skills_delete_title')"
                    required-skills-delete-text="@lang('tessify-core::tasks.create_form_required_skills_delete_text')"
                    required-skills-delete-cancel-text="@lang('tessify-core::tasks.create_form_required_skills_delete_cancel')"
                    required-skills-delete-submit-text="@lang('tessify-core::tasks.create_form_required_skills_delete_submit')"
                    no-skills-text="@lang('tessify-core::tasks.create_form_no_skills')"
                    urgency-text="@lang('tessify-core::tasks.create_form_urgency')"
                    back-href="{{ is_null($project) ? route('tasks') : route('projects.tasks', $project->slug) }}"
                    back-text="@lang('tessify-core::tasks.create_back')"
                    submit-text="@lang('tessify-core::tasks.create_submit')">
                </task-form>
                
            </form>

        </div>
    </div>
@stop