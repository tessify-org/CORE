@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("messages.send") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">@lang("tessify-core::messages.title")</h1>
            <h2 class="page-subtitle centered">@lang("tessify-core::messages.send_title")</h2>
        
            @include("tessify-core::partials.feedback")
            
            <div id="messages">
                <div id="messages-sidebar__wrapper">
                    @include("tessify-core::partials.messages-navigation", [
                        "page" => "send",
                    ])
                </div>
                <div id="messages-content__wrapper">
                    <div id="messages-content" class="elevation-1">
                        
                        <form action="{{ route('messages.send.post') }}" method="post">
                            @csrf

                            <send-message-form
                                :users="{{ $users->toJson() }}"
                                :errors="{{ $errors->toJson() }}"
                                :old-input="{{ $oldInput->toJson() }}"
                                :reply-to="{{ !is_null($replyTo) ? $replyTo->toJson() : json_encode(null) }}"
                                user-text="@lang('tessify-core::messages.send_user')"
                                subject-text="@lang('tessify-core::messages.send_subject')"
                                message-text="@lang('tessify-core::messages.send_message')"
                                back-href="{{ route('messages') }}"
                                back-text="@lang('tessify-core::messages.send_back')"
                                submit-text="@lang('tessify-core::messages.send_submit')">
                            </send-message-form>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@stop