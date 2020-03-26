@extends("tessify-core::layouts.admin")

@section("breadcrumbs")
    {!! Breadcrumbs::render("admin.users.delete", $user) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">@lang("tessify-core::admin.users_delete_title")</h1>

            @include("tessify-core::partials.feedback")

            <form action="{{ route('admin.users.delete.post', $user->id) }}" method="post">
                @csrf

                <div class="delete-dialog content-card elevation-1">
                    <div class="content-card__content centered">
                        @lang("tessify-core::admin.users_delete_text", ["name" => $user->formattedName])
                    </div>
                    <div class="content-card__footer">
                        <div class="content-card__footer-left">
                            <v-btn depressed flat href="{{ route('admin.users.view', $user->id) }}">
                                <i class="fas fa-arrow-left"></i>
                                @lang("tessify-core::admin.users_delete_back")
                            </v-btn>
                        </div>
                        <div class="content-card__footer-right">
                            <v-btn dark depressed color="red" type="submit">
                                <i class="fas fa-trash-alt"></i>
                                @lang("tessify-core::admin.users_delete_submit")
                            </v-btn>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
@stop