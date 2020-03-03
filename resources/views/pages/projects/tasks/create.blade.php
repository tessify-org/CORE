@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.tasks.create", $project) !!}
@stop

@section("content")
    <!-- Content -->
    <div id="apply-for-project" class="content-section__wrapper">
        <div class="content-section">

            <h1 id="delete-dialog__title" class="page-title centered">
                @lang("tessify-core::projects.tasks_create_title")
            </h1>

            <form action="{{ route('projects.tasks.create.post', $project->slug) }}" method="post">
                @csrf
                
                <task-form
                    :skills="{{ $skills->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    :categories="{{ $categories->toJson() }}"
                    :seniorities="{{ $seniorities->toJson() }}"
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
                    back-href="{{ route('projects.tasks', $project->slug) }}"
                    back-text="@lang('tessify-core::projects.tasks_create_back')"
                    submit-text="@lang('tessify-core::projects.tasks_create_submit')">
                </task-form>
                
            </form>

        </div>
    </div>
@stop