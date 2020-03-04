@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.tasks.report-progress", $project, $task) !!}
@stop

@section("content")
    <div id="team-member-application">
        <div class="content-section__wrapper">
            <div class="content-section">

                <div id="report-progress">

                    <!-- Title -->
                    <h1 class="page-title centered">@lang("tessify-core::tasks.report_progress_title")</h1>

                    <!-- Feedback -->
                    @include("tessify-core::partials.feedback")

                    <!-- Form -->
                    <form action="{{ route('projects.tasks.report-progress.post', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <report-task-progress-form
                            :errors="{{ $errors->toJson() }}"
                            :old-input="{{ $oldInput->toJson() }}"
                            back-href="{{ route('projects.tasks.view', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}"
                            back-text="@lang('tessify-core::tasks.report_progress_back')"
                            submit-text="@lang('tessify-core::tasks.report_progress_submit')"
                            message-text="@lang('tessify-core::tasks.report_progress_message')"
                            message-placeholder-text="@lang('tessify-core::tasks.report_progress_message_placeholder')"
                            attachment-text="@lang('tessify-core::tasks.report_progress_attachment')"
                            completed-text="@lang('tessify-core::tasks.report_progress_completed')">
                        </report-task-progress-form>

                    </form>

                </div>

            </div>
        </div>
    </div>
@stop