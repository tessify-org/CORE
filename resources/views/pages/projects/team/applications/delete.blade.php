@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.team.applications.delete", $project, $application) !!}
@stop

@section("content")
    <div id="team-member-application">
        <div class="content-section__wrapper">
            <div class="content-section">

                <!-- Title -->
                <h1 class="page-title centered">@lang("tessify-core::projects.delete_application_title")</h1>

                <!-- Feedback -->
                @include("tessify-core::partials.feedback")

                <!-- Form -->
                <form action="{{ route('projects.team.applications.delete.post', ['slug' => $project->slug, 'uuid' => $application->uuid]) }}" method="post">
                    @csrf

                    <div id="delete-dialog" class="elevation-1">
                        <div id="delete-dialog__text">
                            {!! nl2br(__('tessify-core::projects.delete_application_text', ['title' => $project->title])) !!}
                        </div>
                        <div id="delete-dialog__actions">
                            <div id="delete-dialog__actions-left">
                                <v-btn href="{{ route('projects.view', $project->slug) }}" outlined>
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