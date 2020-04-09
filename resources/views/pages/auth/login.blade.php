@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("auth.login") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">
                @lang('tessify-core::auth.login_title')
            </h1>

            <div id="login" class="elevation-1">

                @include("tessify-core::partials.feedback")

                <form action="{{ route('auth.login.post') }}" method="post">
                    @csrf
                    
                    <login-form
                        :errors="{{ $errors->toJson() }}"
                        :old-input="{{ $oldInput->toJson() }}"
                        email-text="@lang('tessify-core::auth.login_email')"
                        password-text="@lang('tessify-core::auth.login_password')"
                        remember-me-text="@lang('tessify-core::auth.login_remember_me')"
                        submit-text="@lang('tessify-core::auth.login_submit')"
                        forgot-password-text="@lang('tessify-core::auth.login_forgot_password')"
                        forgot-password-href="{{ route('auth.forgot-password') }}"
                        register-text="@lang('tessify-core::auth.login_register_text')">
                    </login-form>

                    <div id="no-account">
                        <a href="{{ route('auth.register') }}">
                            @lang('tessify-core::auth.login_register_text')
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
@stop