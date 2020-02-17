@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("auth.forgot-password") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">@lang('tessify-core::auth.forgot_password_email_sent_title')</h1>
        
            @include("partials.feedback")

            <div id="forgot-password-email-sent" class="elevation-1">
                <div id="forgot-password-email-sent__text">
                    @lang("tessify-core::auth.forgot_password_email_sent_text", ["email" => $email])
                </div>
            </div>

        </div>
    </div>
@stop