@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("messages.read", $message) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::messages.title")</h1>

            <!-- Subtitle -->
            @if ($state == "sender")
                <h2 class="page-subtitle centered">@lang("tessify-core::messages.read_title_sent")</h2>
            @else
                <h2 class="page-subtitle centered">@lang("tessify-core::messages.read_title_received")</h2>
            @endif
        
            <!-- Feedback -->
            @include("tessify-core::partials.feedback")
            
            <!-- Message -->
            <div id="message-wrapper">
                
                <div id="message" class="elevation-1">

                    <!-- Details -->
                    <div id="message-details">
                        @if ($state == "sender")
                            <!-- Sent to -->
                            <div class="message-detail">
                                <div class="message-detail__label">@lang("tessify-core::messages.read_sent_to")</div>
                                <div class="message-detail__value">{{ $message->receiver->formatted_name }}</div>
                            </div>
                        @else
                            <!-- Received from -->
                            <div class="message-detail">
                                <div class="message-detail__label">@lang("tessify-core::messages.read_received_from")</div>
                                <div class="message-detail__value">{{ $message->sender->formatted_name }}</div>
                            </div>
                        @endif
                        <!-- Subject -->
                        <div class="message-detail">
                            <div class="message-detail__label">@lang("tessify-core::messages.read_subject")</div>
                            <div class="message-detail__value">{{ $message->subject }}</div>
                        </div>
                        <!-- Message -->
                        <div class="message-detail">
                            <div class="message-detail__label">@lang("tessify-core::messages.read_message")</div>
                            <div class="message-detail__value">
                                {!! nl2br($message->message) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Received on -->
                    <div id="message-received-on">{{ $message->created_at->format("d-m-Y H:i:s") }}</div>

                </div>
                    
                <!-- Actions -->
                <div class="form-controls">
                    <div class="form-controls__left">
                        @if ($state == "sender")
                            <v-btn outlined href="{{ route('messages.outbox') }}">
                                <i class="fas fa-arrow-left"></i>
                                @lang('tessify-core::messages.read_back_outbox')
                            </v-btn>
                        @else
                            <v-btn outlined href="{{ route('messages') }}">
                                <i class="fas fa-arrow-left"></i>
                                @lang('tessify-core::messages.read_back_inbox')
                            </v-btn>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
@stop