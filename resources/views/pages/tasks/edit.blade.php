@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks.edit", $task) !!}
@stop

@section("content")
    <!-- Content -->
    <div id="apply-for-project" class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 id="delete-dialog__title" class="page-title centered">
                @lang("tessify-core::tasks.edit_title")
            </h1>

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")
            
            <!-- Form -->
            <form action="{{ route('tasks.edit.post', ['slug' => $task->slug]) }}" method="post">
                @csrf
                
                <task-form
                    :task="{{ $task->toJson() }}"
                    :skills="{{ $skills->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    :projects="{{ $projects->toJson() }}"
                    :statuses="{{ $statuses->toJson() }}"
                    :categories="{{ $categories->toJson() }}"
                    :seniorities="{{ $seniorities->toJson() }}"
                    :tags="{{ $tags->toJson() }}"
                    :strings="{{ $strings->toJson() }}"
                    back-href="{{ route('tasks.view', $task->slug) }}">
                </task-form>
                
            </form>

        </div>
    </div>
@stop