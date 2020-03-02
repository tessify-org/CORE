@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("notifications") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">@lang("tessify-core::notifications.title")</h1>
        
            @include("tessify-core::partials.feedback")
            
            <div id="notifications">
                
                <notification-overview
                    :notifications="{{ $notifications->toJson() }}"
                    no-records-text="@lang('tessify-core::notifications.no_records')"
                    clear-text="@lang('tessify-core::notifications.clear')"
                    clear-href="{{ route('notifications.clear') }}"
                    dialog-title-text="@lang('tessify-core::notifications.dialog_title')"
                    title-text="@lang('tessify-core::notifications.details_title')"
                    description-text="@lang('tessify-core::notifications.details_description')"
                    received-on-text="@lang('tessify-core::notifications.details_received_on')">
                </notification-overview>

            </div>

        </div>
    </div>
@stop