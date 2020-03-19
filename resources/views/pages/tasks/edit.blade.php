@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks.edit", $task) !!}
@stop

@section("content")
    <!-- Content -->
    <div id="apply-for-project" class="content-section__wrapper">
        <div class="content-section">

            <h1 id="delete-dialog__title" class="page-title centered">
                @lang("tessify-core::projects.tasks_edit_title")
            </h1>

            <form action="{{ route('tasks.edit.post', ['slug' => $task->slug]) }}" method="post">
                @csrf
                
                <task-form
                    :task="{{ $task->toJson() }}"
                    :skills="{{ $skills->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :projects="{{ $projects->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    :statuses="{{ $statuses->toJson() }}"
                    :categories="{{ $categories->toJson() }}"
                    :seniorities="{{ $seniorities->toJson() }}"
                    project-text="@lang('tessify-core::projects.tasks_form_project')"
                    title-text="@lang('tessify-core::projects.tasks_form_title')"
                    status-text="@lang('tessify-core::projects.tasks_form_status')"
                    category-text="@lang('tessify-core::projects.tasks_form_category')"
                    seniority-text="@lang('tessify-core::projects.tasks_form_seniority')"
                    title-text="@lang('tessify-core::projects.tasks_form_title')"
                    description-text="@lang('tessify-core::projects.tasks_form_description')"
                    complexity-text="@lang('tessify-core::projects.tasks_form_complexity')"
                    estimated-hours-text="@lang('tessify-core::projects.tasks_form_estimated_hours')"
                    realized-hours-text="@lang('tessify-core::projects.tasks_form_realized_hours')"
                    select-category-text="@lang('tessify-core::projects.tasks_form_select_category')"
                    no-categories-text="@lang('tessify-core::projects.tasks_form_no_categories')"
                    select-seniority-text="@lang('tessify-core::projects.tasks_form_select_seniority')"
                    no-seniorities-text="@lang('tessify-core::projects.tasks_form_no_seniorities')"
                    required-skills-text="@lang('tessify-core::projects.tasks_form_required_skills')"
                    urgency-text="@lang('tessify-core::projects.tasks_form_urgency')"
                    back-href="{{ route('tasks.view', $task->slug) }}"
                    back-text="@lang('tessify-core::projects.tasks_edit_back')"
                    submit-text="@lang('tessify-core::general.save_changes')">
                </task-form>
                
            </form>

        </div>
    </div>
@stop