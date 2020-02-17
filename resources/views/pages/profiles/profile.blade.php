@extends("layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("profile", $user) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Profile -->
            <div id="profile">

                <!-- Page title -->
                <h1 class="page-title centered">@lang("tessify-core::profiles.profile_title")</h1>

                <!-- Profile header -->
                <div id="profile-header">
                    <div id="profile-header__avatar-wrapper">
                        <img id="profile-avatar" class="elevation-1" src="{{ is_null($user->avatar_url) ? Avatar::create($user->combinedName)->toBase64() : $user->avatar_url }}" />
                    </div>
                    <div id="profile-header__text-wrapper">
                        <h2 class="page-subtitle">{{ $user->combinedName }}</h2>
                    </div>
                </div>

                <!-- Feedback -->
                @include("partials.feedback")

                <!-- Profile information -->
                <div id="profile__info">

                    <!-- Account details -->
                    <div class="details elevation-1">
                        <div class="detail">
                            <div class="key">@lang("tessify-core::profiles.profile_name")</div>
                            <div class="val">{{ $user->formattedName }}</div>
                        </div>
                        <div class="detail">
                            <div class="key">@lang("tessify-core::profiles.profile_email")</div>
                            <div class="val">{{ $user->email }}</div>
                        </div>
                        <div class="detail">
                            <div class="key">@lang("tessify-core::profiles.profile_email_activated")</div>
                            <div class="val">
                                @if (is_null($user->email_activated_at))
                                    <span class="red-text">
                                        @lang("tessify-core::profiles.profile_email_not_activated")
                                    </span>
                                @else
                                    <span class="green-text">
                                        @lang("tessify-core::profiles.profile_email_activated_on", ["date" => $user->email_activated_at->format("d-m-Y")])
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="detail">
                            <div class="key">@lang("tessify-core::profiles.profile_phone_nr")</div>
                            <div class="val">
                                @if (is_null($user->phone))
                                    <span class="italic">
                                        @lang("tessify-core::profiles.missing")
                                    </span>
                                @else
                                    {{ $user->phone }}
                                @endif
                            </div>
                        </div>
                        <div class="detail">
                            <div class="key">@lang("tessify-core::profiles.profile_created_at")</div>
                            <div class="val">{{ $user->created_at->format("d-m-Y") }}</div>
                        </div>
                        <div class="detail">
                            <div class="key">@lang("tessify-core::profiles.profile_updated_at")</div>
                            <div class="val">{{ $user->updated_at->format("d-m-Y") }}</div>
                        </div>
                    </div>
                    
                </div>

                <div id="profile__actions">
                    <v-btn color="primary" href="{{ route('profile.update') }}">
                        @lang("tessify-core::profiles.profile_update_button")
                    </v-btn>
                </div>

            </div>  

        </div>
    </div>
@stop