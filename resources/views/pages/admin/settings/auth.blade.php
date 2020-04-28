@extends("tessify-core::layouts.admin")

@section("breadcrumbs")
    {!! Breadcrumbs::render("admin.settings.auth") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::admin.settings_auth_title")</h1>

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Form -->
            <form action="{{ route('admin.settings.auth.post') }}" method="post">
                @csrf

                <auth-settings-form
                    :whitelisted-domains="{{ $whitelistedDomains->toJson() }}"
                    :settings="{{ $settings->toJson() }}"
                    :old-input="{{ $oldInput->toJson() }}"
                    :errors="{{ $errors->toJson() }}">
                </auth-settings-form>

                <!-- Form controls -->
                <div class="form-controls">
                    <div class="form-controls__left">
                        <v-btn text href="{{ route('admin.settings') }}">
                            <i class="fas fa-arrow-left"></i>
                            @lang("tessify-core::admin.settings_auth_back")
                        </v-btn>
                    </div>
                    <div class="form-controls__right">
                        <v-btn type="submit" color="success">
                            <i class="fas fa-save"></i>
                            @lang("tessify-core::admin.settings_auth_submit")
                        </v-btn>
                    </div>
                </div>

            </form>

        </div>
    </div>
@stop