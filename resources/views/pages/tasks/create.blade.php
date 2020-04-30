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

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Open form -->
            <form action="{{ route('tasks.create.post') }}" method="post">
                @csrf

                <!-- Render form -->
                <task-form
                    :project="{{ is_null($project) ? json_encode(null) : $project->toJson() }}"
                    :skills="{{ $skills->toJson() }}"
                    :ministries="{{ $ministries->toJson() }}"
                    :organizations="{{ $organizations->toJson() }}"
                    :departments="{{ $departments->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    :projects="{{ $projects->toJson() }}"
                    :categories="{{ $categories->toJson() }}"
                    :seniorities="{{ $seniorities->toJson() }}"
                    :tags="{{ $tags->toJson() }}"
                    :strings="{{ $strings->toJson() }}"
                    back-href="{{ is_null($project) ? route('tasks') : route('projects.tasks', $project->slug) }}">
                </task-form>
                
            </form>

        </div>
    </div>
@stop