@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("tasks.progress-report", $task, $report) !!}
@stop

@section("content")
    <div id="team-member-application">
        <div class="content-section__wrapper">
            <div class="content-section">

                <div id="progress-report">

                    <!-- Title -->
                    <h1 class="page-title centered">@lang("tessify-core::tasks.progress_report_title")</h1>

                    <!-- Feedback -->
                    @include("tessify-core::partials.feedback")

                    <!-- Info -->
                    <div id="progress-report__info" class="content-box elevation-1">
                        
                        <!-- Message -->
                        <div class="progress-report__field">
                            <div class="progress-report__field-label">
                                @lang("tessify-core::tasks.progress_report_message")
                            </div>
                            <div class="progress-report__field-text">
                                {!! nl2br($report->message) !!}
                            </div>
                        </div>

                        <!-- Attachments -->
                        <div class="progress-report__field">
                            <div class="progress-report__field-label">
                                @lang("tessify-core::tasks.progress_report_attachments")
                            </div>
                            @if (count($report->attachments))
                                <div class="progress-report__field-attachments">
                                    <?php $i = 1; ?>
                                    @foreach ($report->attachments as $attachment)
                                        <a target="_blank" href="{{ asset($attachment->file_url) }}">
                                            @lang("tessify-core::tasks.progress_report_attachment") #{{ $i }}
                                        </a>
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                            @else
                                <div class="progress-report__field-no-attachments">
                                    @lang("tessify-core::tasks.progress_report_no_attachments")
                                </div>
                            @endif
                        </div>

                        <!-- Status complete -->
                        @if ($report->completed)
                            <div class="progress-report__field">
                                <div class="progress-report__field-label">
                                    @lang("tessify-core::tasks.progress_report_completed")
                                </div>
                                <div class="progress-report__field-text">
                                    @lang("tessify-core::tasks.progress_report_completed_text", ["user" => $report->user->first_name])
                                </div>
                            </div>
                        @endif

                        <!-- Date submitted -->
                        <div id="progress-report__date">{{ $report->created_at->format("d-m-Y H:m:s") }}</div>

                    </div>

                    <!-- Review -->
                    @if (count($report->reviews))
                        @foreach ($report->reviews as $review)
                            <div class="progress-report__review elevation-1">
                                <div class="review-title">@lang("tessify-core::tasks.progress_report_review")</div>
                                <div class="review-text">
                                    {!! nl2br($review->message) !!}
                                </div>
                                <div class="review-footer">
                                    <div class="review-footer__left">
                                        <div class="review-author">
                                            {{ ucfirst(__("tessify-core::general.by")) }} {{ $review->user->formatted_name }}
                                        </div>
                                    </div>
                                    <div class="review-footer__right">
                                        <div class="review-date">
                                            {{ $review->created_at->format("d-m-Y H:i:s") }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- Actions -->
                    <div id="progress-report__actions">
                        
                        <!-- Go back to task -->
                        <v-btn href="{{ route('tasks.view', ['slug' => $task->slug]) }}">
                            <i class="fas fa-arrow-left"></i>
                            @lang("tessify-core::tasks.progress_report_back")
                        </v-btn>

                        <!-- Task/Project owner actions -->
                        @if (($task->is_owner or $task->is_project_owner) and !$report->has_been_reviewed)

                            <!-- Review report -->
                            <v-btn color="primary" href="{{ route('tasks.progress-report.review', ['slug' => $task->slug, 'uuid' => $report->uuid]) }}">
                                <i class="fas fa-comments"></i>
                                @lang("tessify-core::tasks.progress_report_place_review")
                            </v-btn>
                        
                            <!-- Complete task -->
                            <v-btn color="success" href="{{ route('tasks.complete', ['slug' => $task->slug]) }}">
                                <i class="fas fa-check"></i>
                                @lang("tessify-core::tasks.progress_report_complete")
                            </v-btn>
                        
                        @endif

                    </div>

                </div>

            </div>
        </div>
    </div>
@stop