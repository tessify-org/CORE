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

            <div id="login-wrapper">

                @include("tessify-core::partials.feedback")

                <div id="login" class="elevation-1">

                    <form action="{{ route('auth.login.post') }}" method="post">
                        @csrf
                        
                        <login-form
                            :errors="{{ $errors->toJson() }}"
                            :old-input="{{ $oldInput->toJson() }}"
                            :strings="{{ $strings->toJson() }}"
                            forgot-password-href="{{ route('auth.forgot-password') }}"
                            register-href="{{ route('auth.register') }}">
                        </login-form>
                        
                    </form>
                </div>

            </div>

        </div>
    </div>
@stop