@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.team.applications.edit", $project, $application) !!}
@stop

@section("content")
    <div id="team-member-application">
        <div class="content-section__wrapper">
            <div class="content-section">

                <!-- Title -->
                <h1 class="page-title centered">@lang("tessify-core::projects.edit_application_title")</h1>

                <!-- Feedback -->
                @include("tessify-core::partials.feedback")

                <!-- Form -->
                <form action="{{ route('projects.team.applications.edit.post', ['slug' => $project->slug, 'uuid' => $application->uuid]) }}" method="post">
                    @csrf

                    <team-member-application-form
                        :errors="{{ $errors->toJson() }}"
                        :old-input="{{ $oldInput->toJson() }}"
                        :application="{{ $application->toJson() }}"
                        :roles="{{ $roles->toJson() }}"
                        back-text="@lang('tessify-core::general.go_back')"
                        back-href="{{ route('projects.team.applications.view', ['slug' => $project->slug, 'uuid' => $application->uuid]) }}"
                        submit-text="@lang('tessify-core::general.save_changes')"
                        role-text="@lang('tessify-core::projects.edit_application_role')"
                        motivation-text="@lang('tessify-core::projects.edit_application_motivation')">
                    </team-member-application-form>

                </form>

            </div>
        </div>
    </div>
@stop