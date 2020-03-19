@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks.report-progress", $task, $report) !!}
@stop

@section("content")
    <div id="team-member-application">
        <div class="content-section__wrapper">
            <div class="content-section">

                <div id="review-progress-report">

                    <!-- Title -->
                    <h1 class="page-title centered">@lang("tessify-core::tasks.review_progress_report_title")</h1>

                    <!-- Feedback -->
                    @include("tessify-core::partials.feedback")

                    <!-- Form -->
                    <form action="{{ route('tasks.progress-report.review.post', ['slug' => $task->slug, 'uuid' => $report->uuid]) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <review-progress-report-form
                            :report="{{ $report->toJson() }}"
                            :errors="{{ $errors->toJson() }}"
                            :old-input="{{ $oldInput->toJson() }}"
                            message-text="@lang('tessify-core::tasks.review_progress_report_message')"
                            back-href="{{ route('tasks.progress-report', ['slug' => $task->slug, 'uuid' => $report->uuid]) }}"
                            back-text="@lang('tessify-core::tasks.review_progress_report_back')"
                            submit-text="@lang('tessify-core::tasks.review_progress_report_submit')">
                        </review-progress-report-form>

                    </form>

                </div>

            </div>
        </div>
    </div>
@stop