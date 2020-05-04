@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks.abandon", $task) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::tasks.abandon_title")</h1>

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Form -->
            <form action="{{ route('tasks.abandon.post', ['slug' => $task->slug]) }}" method="post">
                @csrf

                <task-abandon-form
                    :task="{{ $task->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :strings="{{ $strings->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    back-href="{{ route('tasks.view', ['slug' => $task->slug]) }}">
                </task-abandon-form>

            </form>

        </div>
    </div>
@stop