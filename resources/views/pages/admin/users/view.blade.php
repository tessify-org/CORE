@extends("tessify-core::layouts.admin")

@section("breadcrumbs")
    {!! Breadcrumbs::render("admin.users.view", $user) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">@lang("tessify-core::admin.users_view_title")</h1>

            @include("tessify-core::partials.feedback")

            <div id="admin-users-view">
                <div id="admin-users-view__left">

                    <!-- Details -->
                    <div class="content-card elevation-1">
                        <div class="details">
                            <!-- ID -->
                            <div class="detail">
                                <div class="key">ID</div>
                                <div class="val">{{ $user->id }}</div>
                            </div>
                            <!-- Admin -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::admin.users_view_admin")</div>
                                <div class="val">
                                    @if ($user->is_admin)
                                        <span class="green-text">@lang("tessify-core::general.yes")</span>
                                    @else
                                        <span class="red-text">@lang("tessify-core::general.no")</span>
                                    @endif
                                </div>
                            </div>
                            <!-- Name -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::admin.users_view_name")</div>
                                <div class="val">{{ $user->formattedName }}</div>
                            </div>
                            <!-- Email -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::admin.users_view_email")</div>
                                <div class="val">{{ $user->email }}</div>
                            </div>
                            <!-- Email verified -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::admin.users_view_email_verified")</div>
                                <div class="val">
                                    @if ($user->email_verified_at)
                                        <span class="green-text">@lang("tessify-core::general.yes")</span>
                                        <span style="margin: 0 0 0 10px;">({{ $user->email_verified_at->format("d-m-Y H:m:s") }})</span>
                                    @else
                                        <span class="red-text">@lang("tessify-core::general.no")</span>
                                    @endif
                                </div>
                            </div>
                            <!-- Phone number -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::admin.users_view_phone")</div>
                                <div class="val">
                                    @if ($user->phone)
                                        {{ $user->phone }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <!-- Headline -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::admin.users_view_headline")</div>
                                <div class="val">{{ $user->headline }}</div>
                            </div>
                            <!-- Interests -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::admin.users_view_interests")</div>
                                <div class="val">{{ $user->interests }}</div>
                            </div>
                            <!-- Reputation points -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::admin.users_view_reputation")</div>
                                <div class="val">{{ $user->reputation_points }}</div>
                            </div>
                            <!-- Has been checked -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::admin.users_view_checked")</div>
                                <div class="val">
                                    @if ($user->has_been_checked)
                                        <span class="green-text">@lang("tessify-core::general.yes")</span>
                                    @else
                                        <span class="red-text">@lang("tessify-core::general.no")</span>
                                    @endif
                                </div>
                            </div>
                            <!-- Banned -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::admin.users_view_banned")</div>
                                <div class="val">
                                    @if ($user->permabanned)
                                        <span class="red-text">@lang("tessify-core::admin.users_view_banned_permanently")</span>
                                    @elseif ($user->banned_until)
                                        <span class="red-text">@lang("tessify-core::admin.users_view_banned_temporarily")</span>
                                        <span style="margin: 0 0 0 10px;">({{ $user->banned_until->format("d-m-Y H:m:s") }})</span>
                                    @else
                                        <span class="green-text">@lang("tessify-core::general.no")</span>
                                    @endif
                                </div>
                            </div>
                            <!-- Updated at -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::general.updated_at")</div>
                                <div class="val">{{ $user->updated_at->format("d-m-Y H:m:s") }}</div>
                            </div>
                            <!-- Created at -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::general.created_at")</div>
                                <div class="val">{{ $user->created_at->format("d-m-Y H:m:s") }}</div>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="admin-users-view__right">

                    <!-- Actions -->
                    <div id="admin-users-view__actions">
                        <!-- Flag as checked -->
                        @if ($user->has_been_checked)
                            <v-btn block color="primary" dark href="{{ route('admin.users.unflag-as-checked', $user->id) }}">
                                <i class="far fa-flag"></i>
                                @lang("tessify-core::admin.users_view_unflag_as_checked")
                            </v-btn>
                        @else
                            <v-btn block color="primary" dark href="{{ route('admin.users.flag-as-checked', $user->id) }}">
                                <i class="fas fa-user-check"></i>
                                @lang("tessify-core::admin.users_view_flag_as_checked")
                            </v-btn>
                        @endif
                        <!-- Update -->
                        <v-btn block color="warning" href="{{ route('admin.users.edit', $user->id) }}">
                            <i class="fas fa-user-edit"></i>
                            @lang("tessify-core::general.edit")
                        </v-btn>
                        <!-- Delete -->
                        <v-btn block color="red" dark href="{{ route('admin.users.delete', $user->id) }}">
                            <i class="fas fa-user-slash"></i>
                            @lang("tessify-core::general.delete")
                        </v-btn>
                        <!-- Ban / Unban -->
                        @if ($user->banned_until or $user->permabanned)
                            <v-btn block color="green" dark href="{{ route('admin.users.unban', $user->id) }}">
                                <i class="fas fa-gavel"></i>
                                @lang("tessify-core::admin.users_view_unban")
                            </v-btn>
                        @else
                            <v-btn block color="red" dark href="{{ route('admin.users.ban', $user->id) }}">
                                <i class="fas fa-gavel"></i>
                                @lang("tessify-core::admin.users_view_ban")
                            </v-btn>
                        @endif
                        <!-- Change password -->
                        <v-btn block color="primary" dark href="{{ route('admin.users.change-password', $user->id) }}">
                            <i class="fas fa-key"></i>
                            @lang("tessify-core::admin.users_view_change_password")
                        </v-btn>
                        <!-- Send message -->
                        <v-btn block color="primary" dark href="{{ route('admin.users.send-message', $user->id) }}">
                            <i class="fas fa-paper-plane"></i>
                            @lang("tessify-core::admin.users_view_send_message")
                        </v-btn>
                    </div>
                </div>
            </div>

            <div class="page-controls">
                <div class="page-controls__left">
                    <v-btn color="primary" href="{{ route('admin.users') }}">
                        <i class="fas fa-arrow-left"></i>
                        @lang("tessify-core::admin.users_view_go_back")
                    </v-btn>
                </div>
            </div>

        </div>
    </div>
@stop