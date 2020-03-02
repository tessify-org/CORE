@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("messages.outbox") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">@lang("tessify-core::messages.title")</h1>
            <h2 class="page-subtitle centered">@lang("tessify-core::messages.outbox_title")</h2>
        
            @include("tessify-core::partials.feedback")
            
            <div id="messages">
                <div id="messages-sidebar__wrapper">
                    @include("tessify-core::partials.messages-navigation", [
                        "page" => "outbox",
                    ])
                </div>
                <div id="messages-content__wrapper">
                    <messages-outbox
                        :messages="{{ $messages->toJson() }}"
                        no-records-text="@lang('tessify-core::messages.outbox_empty')">
                    </messages-outbox>
                </div>
            </div>

        </div>
    </div>
@stop