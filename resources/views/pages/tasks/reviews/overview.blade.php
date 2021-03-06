@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks.reviews", $task) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Task page -->
            <div id="view-task">
                <aside id="view-task__sidebar">

                    @include("tessify-core::partials.tasks.view-sidebar", [
                        "task" => $task,
                        "page" => "reviews",
                    ])

                </aside>
                <main id="view-task__content">

                    <!-- Task information -->
                    <div id="task" class="elevation-2">

                        <!-- Header -->
                        <div id="task-header">
                            <div id="task-header__bg" style="background-image: url({{ asset($task->header_image_url) }})"></div>
                            <div id="task-header__bg-overlay"></div>
                            <div id="task-header__text">
                                <!-- Page title -->
                                <h1 id="task-title">{{ $task->title }}</h1>
                                <!-- Task project -->
                                @if ($task->project)
                                    <h2 id="task-project">{!! __("tessify-core::tasks.view_part_of_project", ["title" => $task->project->title]) !!}</h2>
                                @endif
                            </div>
                            <div id="task-header__actions">
                                <v-btn outlined href="{{ route('tasks.view', $task->slug) }}">
                                    <i class="fas fa-arrow-left"></i>
                                    @lang("tessify-core::tasks.back_to_task")
                                </v-btn>
                            </div>
                        </div>

                        <!-- Content -->
                        <div id="task-content">
                        
                            <!-- Content header -->
                            <div id="task-content__header">
                                <div id="task-content__header-left">
                                
                                    <!-- Title -->
                                    <h1 id="task-title">@lang("tessify-core::tasks.reviews_title")</h1>

                                    <!-- Review overview -->
                                    <task-review-overview
                                        :task="{{ $task->toJson() }}"
                                        :reviews="{{ $reviews->toJson() }}"
                                        :strings="{{ $strings->toJson() }}">
                                    </task-review-overview>

                                </div>
                            </div>


                        </div>
                    </div>


                </main>
            </div>

        </div>
    </div>
@stop