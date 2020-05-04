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

            <!-- Message -->
            <div id="message-wrapper">

                <!-- Feedback -->
                @include("tessify-core::partials.feedback")
                
                <div id="message" class="elevation-1">

                    <!-- Details -->
                    <div id="message-details">
                        <!-- Receiver / Sender -->
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
                        <!-- Request access to email -->
                        @if ($message->type == "request_access_to_email")
                            @if ($message->data["request_processed"])
                                @if ($message->data["request_accepted"])
                                    <div id="request-result" class="accepted">
                                        <div id="request-result__text">
                                            @lang("tessify-core::messages.request_accepted")
                                        </div>
                                    </div>
                                @else
                                    <div id="request-result" class="rejected">
                                        <div id="request-result__text">
                                            @lang("tessify-core::messages.request_rejected")
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div id="request-actions">
                                    <div id="request-actions__left">
                                        <v-btn block large dark color="red" href="{{ route('profile.request-access-email.reject', ['messageUuid' => $message->uuid, 'requestUuid' => $message->data['uuid']]) }}">
                                            @lang("tessify-core::messages.request_action_deny")
                                        </v-btn>
                                    </div>
                                    <div id="request-actions__right">
                                        <v-btn block large dark color="green" href="{{ route('profile.request-access-email.accept', ['messageUuid' => $message->uuid, 'requestUuid' => $message->data['uuid']]) }}">
                                            @lang("tessify-core::messages.request_action_accept")
                                        </v-btn>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <!-- Invitation to task -->
                        @if ($message->type == "invite_to_task")
                            <div id="invitation">
                                <div id="invitation-action">
                                    <v-btn large color="primary" href="{{ route('tasks.view', $message->data['task_slug']) }}">
                                        <i class="fas fa-eye"></i>
                                        @lang("tessify-core::messages.task_invite_button")
                                    </v-btn>
                                </div>
                            </div>
                        @endif
                        <!-- Invitation to project -->
                        @if ($message->type == "invite_to_project")
                            <div id="invitation">
                                <div id="invitation-action">
                                    <v-btn large color="primary" href="{{ route('projects.view', $message->data['project_slug']) }}">
                                        <i class="fas fa-eye"></i>
                                        @lang("tessify-core::messages.project_invite_button")
                                    </v-btn>
                                </div>
                            </div>
                        @endif
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
                    @if ($state == "receiver")
                        <div class="form-controls__right">
                            <v-btn color="primary" href="{{ route('messages.send', $message->uuid) }}">
                                <i class="fas fa-paper-plane"></i>
                                @lang("tessify-core::messages.read_reply")
                            </v-btn>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
@stop