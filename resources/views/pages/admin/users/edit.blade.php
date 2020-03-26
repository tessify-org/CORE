@extends("tessify-core::layouts.admin")

@section("breadcrumbs")
    {!! Breadcrumbs::render("admin.users.edit", $user) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">@lang("tessify-core::admin.users_edit_title")</h1>

            @include("tessify-core::partials.feedback")

            <form action="{{ route('admin.users.edit.post', $user->id) }}" method="post">
                @csrf

                <div class="content-card elevation-1">
                    <div class="content-card__content">
                        <user-form
                            :user="{{ $user->toJson() }}"
                            :errors="{{ $errors->toJson() }}"
                            :old-input="{{ $oldInput->toJson() }}"
                            is-admin-text="@lang('tessify-core::admin.users_form_is_admin')"
                            annotation-text="@lang('tessify-core::admin.users_form_annotation')"
                            first-name-text="@lang('tessify-core::admin.users_form_first_name')"
                            last-name-text="@lang('tessify-core::admin.users_form_last_name')"
                            email-text="@lang('tessify-core::admin.users_form_email')"
                            password-text="@lang('tessify-core::admin.users_form_password')"
                            confirm-password-text="@lang('tessify-core::admin.users_form_confirm_password')"
                            headline-text="@lang('tessify-core::admin.users_form_headline')"
                            interests-text="@lang('tessify-core::admin.users_form_interests')">
                        </user-form>
                    </div>
                    <div class="content-card__footer">
                        <div class="content-card__footer-left">
                            <v-btn flat depressed href="{{ route('admin.users.view', $user->id) }}">
                                <i class="fas fa-arrow-left"></i>
                                @lang("tessify-core::general.go_back")
                            </v-btn>
                        </div>
                        <div class="content-card__footer-right">
                            <v-btn dark depressed color="green" type="submit">
                                <i class="fas fa-save"></i>
                                @lang("tessify-core::admin.users_edit_submit")
                            </v-btn>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
@stop