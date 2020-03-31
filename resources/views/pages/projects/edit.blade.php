@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.edit", $project) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">
                @lang("tessify-core::projects.update_title")
            </h1>
        
            @include("tessify-core::partials.feedback")

            <form action="{{ route('projects.edit.post', $project->slug) }}" method="post" enctype="multipart/form-data">
                @csrf

                <project-form
                    :project="{{ $project->toJson() }}"
                    :project-statuses="{{ $statuses->toJson() }}"
                    :project-categories="{{ $categories->toJson() }}"
                    :work-methods="{{ $workMethods->toJson() }}"
                    :skills="{{ $skills->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    create-resource-api-endpoint="{{ route('api.projects.resources.create.post') }}"
                    update-resource-api-endpoint="{{ route('api.projects.resources.update.post') }}"
                    delete-resource-api-endpoint="{{ route('api.projects.resources.delete.post') }}"
                    title-text="@lang('tessify-core::projects.form_title')"
                    title-hint-text="@lang('tessify-core::projects.form_title_hint')"
                    slogan-text="@lang('tessify-core::projects.form_slogan')"
                    slogan-hint-text="@lang('tessify-core::projects.form_slogan_hint')"
                    description-text="@lang('tessify-core::projects.form_description')"
                    description-hint-text="@lang('tessify-core::projects.form_description_hint')"
                    header-image-text="@lang('tessify-core::projects.form_header_image')"
                    roles-text="@lang('tessify-core::projects.form_roles')"
                    resources-text="@lang('tessify-core::projects.form_resources')"
                    category-text="@lang('tessify-core::projects.form_category')"
                    work-method-text="@lang('tessify-core::projects.form_work_method')"
                    status-text="@lang('tessify-core::projects.form_status')"
                    has-tasks-text="@lang('tessify-core::projects.form_has_tasks')"
                    has-deadline-text="@lang('tessify-core::projects.form_has_deadline')"
                    start-date-text="@lang('tessify-core::projects.form_start_date')"
                    deadline-text="@lang('tessify-core::projects.form_deadline')"
                    back-text="@lang('tessify-core::projects.update_back')"
                    back-href="{{ route('projects') }}"
                    submit-text="@lang('tessify-core::projects.update_submit')">
                </project-form>

            </form>

        </div>
    </div>
@stop