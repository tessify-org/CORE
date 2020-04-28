@extends("tessify-core::layouts.admin")

@section("breadcrumbs")
    {!! Breadcrumbs::render("admin.settings") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">@lang("tessify-core::admin.settings_overview_title")</h1>

            @include("tessify-core::partials.feedback")

            <div id="settings-overview">
                <div class="settings-overview__link-wrapper">
                    <a class="settings-overview__link elevation-1" href="{{ route('admin.settings.auth') }}">
                        <span class="link-icon">
                            <i class="fas fa-user-shield"></i>
                        </span>
                        <span class="link-text">@lang("tessify-core::admin.settings_overview_auth")</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
@stop