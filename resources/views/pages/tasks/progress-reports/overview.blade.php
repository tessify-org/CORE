@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks.progress-reports", $task) !!}
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
                        "page" => "progress-reports",
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
                                <h1 id="task-title">@lang("tessify-core::tasks.view_title")</h1>
                                <!-- Task title -->
                                <h2 id="task-subtitle">{{ $task->title }}</h2>
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
                                    <h1 id="task-title">@lang("tessify-core::tasks.progress_reports_title")</h1>

                                    <!-- Progress report overview -->
                                    <task-progress-report-overview
                                        :task="{{ $task->toJson() }}"
                                        :reports="{{ $reports->toJson() }}"
                                        :strings="{{ $strings->toJson() }}">
                                    </task-progress-report-overview>

                                </div>
                            </div>


                        </div>
                    </div>


                </main>
            </div>

        </div>
    </div>
@stop