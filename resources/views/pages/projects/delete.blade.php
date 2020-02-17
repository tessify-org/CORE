@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.delete", $project) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 id="delete-dialog__title" class="page-title centered">
                @lang("tessify-core::projects.delete_title")
            </h1>
        
            @include("tessify-core::partials.feedback")

            <form action="{{ route('projects.delete', $project->slug) }}" method="post">
                {{ csrf_field() }}

                <div id="delete-dialog" class="elevation-1">
                    <div id="delete-dialog__text">
                        {!! nl2br(__('tessify-core::projects.delete_text', ['title' => $project->title])) !!}
                    </div>
                    <div id="delete-dialog__actions">
                        <div id="delete-dialog__actions-left">
                            <v-btn href="{{ route('projects.view', $project->slug) }}" outlined>
                                <i class="fas fa-arrow-left"></i>
                                @lang("tessify-core::projects.delete_cancel")
                            </v-btn>
                        </div>
                        <div id="delete-dialog__actions-right">
                            <v-btn type="submit" color="red" dark>
                                <i class="fas fa-trash-alt"></i>
                                @lang("tessify-core::projects.delete_confirm")
                            </v-btn>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
@stop