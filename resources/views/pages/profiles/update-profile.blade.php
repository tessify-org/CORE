@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("profile.update", $user) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Page title -->
            <h1 class="page-title centered">Update Profiel</h1>

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <form action="{{ route('profile.update.post') }}" method="post">
                @csrf

                <update-profile-form
                    :user="{{ $user->toJson() }}"
                    :errors="{{ $errors->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    annotation-text="@lang('tessify-core::profiles.update_profile_annotation')"
                    first-name-text="@lang('tessify-core::profiles.update_profile_first_name')"
                    last-name-text="@lang('tessify-core::profiles.update_profile_last_name')"
                    email-text="@lang('tessify-core::profiles.update_profile_email')"
                    phone-text="@lang('tessify-core::profiles.update_profile_phone')"
                    avatar-text="@lang('tessify-core::profiles.update_profile_avatar')"
                    back-href="{{ route('profile') }}"
                    back-text="@lang('tessify-core::profiles.update_profile_go_back')"
                    save-text="@lang('tessify-core::profiles.update_profile_save_changes')">
                </update-profile-form>

            </form>

        </div>
    </div>
@stop