@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.team.remove-member", $project, $user) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 id="delete-dialog__title" class="page-title centered">
                @lang("tessify-core::projects.remove_from_team_title")
            </h1>
        
            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Open form -->
            <form action="{{ route('projects.team.remove-member.post', ['slug' => $project->slug, 'userSlug' => $user->slug]) }}" method="post">
                @csrf

                <div id="delete-dialog" class="elevation-1">
                    <div id="delete-dialog__text">
                        {!! nl2br(__('tessify-core::projects.remove_from_team_text', ['name' => $user->formattedName])) !!}
                    </div>
                    <div id="delete-dialog__actions">
                        <div id="delete-dialog__actions-left">
                            <v-btn href="{{ route('projects.team.view', $project->slug) }}" outlined>
                                <i class="fas fa-arrow-left"></i>
                                @lang("tessify-core::projects.remove_from_team_cancel")
                            </v-btn>
                        </div>
                        <div id="delete-dialog__actions-right">
                            <v-btn type="submit" color="red" dark depressed>
                                <i class="fas fa-trash-alt"></i>
                                @lang("tessify-core::projects.remove_from_team_submit")
                            </v-btn>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
@stop