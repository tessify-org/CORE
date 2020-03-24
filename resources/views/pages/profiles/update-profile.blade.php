@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("profile.update", $user) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Page title -->
            <h1 class="page-title centered">@lang("tessify-core::profiles.update_profile_title")</h1>

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <form action="{{ route('profile.update.post') }}" method="post" enctype="multipart/form-data">
                @csrf

                <update-profile-form
                    :user="{{ $user->toJson() }}"
                    :skills="{{ $skills->toJson() }}"
                    :assignment-types="{{ $assignmentTypes->toJson() }}"
                    :organizations="{{ $organizations->toJson() }}"
                    :organization-locations="{{ $organizationLocations->toJson() }}"
                    :departments="{{ $departments->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    annotation-text="@lang('tessify-core::profiles.update_profile_annotation')"
                    first-name-text="@lang('tessify-core::profiles.update_profile_first_name')"
                    last-name-text="@lang('tessify-core::profiles.update_profile_last_name')"
                    headline-text="@lang('tessify-core::profiles.update_profile_headline')"
                    email-text="@lang('tessify-core::profiles.update_profile_email')"
                    phone-text="@lang('tessify-core::profiles.update_profile_phone')"
                    avatar-text="@lang('tessify-core::profiles.update_profile_avatar')"
                    assignments-text="@lang('tessify-core::profiles.update_profile_assignments')"
                    interests-text="@lang('tessify-core::profiles.update_profile_interests')"
                    back-href="{{ route('profile') }}"
                    back-text="@lang('tessify-core::profiles.update_profile_go_back')"
                    save-text="@lang('tessify-core::profiles.update_profile_save_changes')"
                    create-assignment-api-endpoint="{{ route('api.assignments.create.post') }}">
                </update-profile-form>

            </form>

        </div>
    </div>
@stop