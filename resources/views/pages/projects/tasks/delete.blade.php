@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.tasks.delete", $project, $task) !!}
@stop

@section("content")
    <div id="team-member-application">
        <div class="content-section__wrapper">
            <div class="content-section">

                <!-- Title -->
                <h1 class="page-title centered">@lang("tessify-core::projects.tasks_delete_title")</h1>

                <!-- Feedback -->
                @include("tessify-core::partials.feedback")

                <!-- Form -->
                <form action="{{ route('projects.tasks.delete.post', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}" method="post">
                    @csrf

                    <div id="delete-dialog" class="elevation-1">
                        <div id="delete-dialog__text">
                            {!! nl2br(__('tessify-core::projects.tasks_delete_text', ['title' => $task->title])) !!}
                        </div>
                        <div id="delete-dialog__actions">
                            <div id="delete-dialog__actions-left">
                                <v-btn href="{{ route('projects.tasks.view', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}" outlined>
                                    <i class="fas fa-arrow-left"></i>
                                    @lang("tessify-core::projects.delete_cancel")
                                </v-btn>
                            </div>
                            <div id="delete-dialog__actions-right">
                                <v-btn type="submit" color="red" dark depressed>
                                    <i class="fas fa-trash-alt"></i>
                                    @lang("tessify-core::projects.delete_confirm")
                                </v-btn>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@stop