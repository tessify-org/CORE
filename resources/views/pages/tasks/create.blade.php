@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks.create", $project) !!}
@stop

@section("content")
    <div id="apply-for-project" class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 id="delete-dialog__title" class="page-title centered">
                @lang("tessify-core::projects.tasks_create_title")
            </h1>

            <!-- Open form -->
            <form action="{{ route('tasks.create.post') }}" method="post">

                <!-- CSRF -->
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
                    project-text="@lang('tessify-core::projects.tasks_form_project')"
                    title-text="@lang('tessify-core::projects.tasks_form_title')"
                    category-text="@lang('tessify-core::projects.tasks_form_category')"
                    seniority-text="@lang('tessify-core::projects.tasks_form_seniority')"
                    title-text="@lang('tessify-core::projects.tasks_form_title')"
                    description-text="@lang('tessify-core::projects.tasks_form_description')"
                    complexity-text="@lang('tessify-core::projects.tasks_form_complexity')"
                    estimated-hours-text="@lang('tessify-core::projects.tasks_form_estimated_hours')"
                    select-category-text="@lang('tessify-core::projects.tasks_form_select_category')"
                    no-categories-text="@lang('tessify-core::projects.tasks_form_no_categories')"
                    select-seniority-text="@lang('tessify-core::projects.tasks_form_select_seniority')"
                    no-seniorities-text="@lang('tessify-core::projects.tasks_form_no_seniorities')"
                    back-href="{{ is_null($project) ? route('tasks') : route('projects.tasks', $project->slug) }}"
                    back-text="@lang('tessify-core::projects.tasks_create_back')"
                    submit-text="@lang('tessify-core::projects.tasks_create_submit')">
                </task-form>
                
            </form>

        </div>
    </div>
@stop