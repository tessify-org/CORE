@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("auth.login") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            @include("tessify-core::partials.feedback")

            <div id="login" class="elevation-1">
                <div id="login-left">

                    <h1 id="login-title">@lang('tessify-core::auth.login_title')</h1>

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
                                @lang('auth.login_register_text')
                            </a>
                        </div>

                    </form>

                </div>
                <div id="login-right">

                    <h2 class="login-subtitle">Wat is mijn NNW?</h2>
                    <div class="login-subtext">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ipsum enim, tempor nec lobortis non, vulputate sit amet 
                        libero. Nunc eget interdum sem. Fusce eu luctus turpis, sed scelerisque turpis. Aliquam tortor nulla, hendrerit eu maximus 
                        eget, egestas nec lectus. Pellentesque convallis imperdiet faucibus.
                    </div>

                    <h2 class="login-subtitle">Meer weten?</h2>
                    <div class="login-subtext">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ipsum enim, tempor nec lobortis non, vulputate sit amet 
                        libero. Nunc eget interdum sem. Fusce eu luctus turpis, sed scelerisque turpis. Aliquam tortor nulla, hendrerit eu maximus 
                        eget, egestas nec lectus. Pellentesque convallis imperdiet faucibus.
                    </div>

                </div>
            </div>

        </div>
    </div>
@stop