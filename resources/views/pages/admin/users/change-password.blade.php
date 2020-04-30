@extends("tessify-core::layouts.admin")

@section("breadcrumbs")
    {!! Breadcrumbs::render("admin.users.change-password", $user) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">@lang("tessify-core::admin.users_change_password_title")</h1>

            @include("tessify-core::partials.feedback")

            <form action="{{ route('admin.users.change-password.post', $user->id) }}" method="post">
                @csrf

                <div class="content-card elevation-1">
                    <div class="content-card__content">
                        
                        <admin-change-password-form
                            :strings="{{ $strings->toJson() }}"
                            :errors="{{ $errors->toJson() }}">
                        </admin-change-password-form>

                    </div>

                    <div class="content-card__footer">
                        <div class="content-card__footer-left">
                            <v-btn text depressed href="{{ route('admin.users.view', $user->id) }}">
                                <i class="fas fa-arrow-left"></i>
                                @lang("tessify-core::admin.users_change_password_back")
                            </v-btn>
                        </div>
                        <div class="content-card__footer-right">
                            <v-btn dark depressed color="green" type="submit">
                                <i class="fas fa-save"></i>
                                @lang("tessify-core::admin.users_change_password_submit")
                            </v-btn>
                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>
@stop