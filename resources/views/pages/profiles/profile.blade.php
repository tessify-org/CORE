@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("profile", $user) !!}
@stop

@section("content")
    <div id="profile">

        <!-- Header -->
        <div id="profile-header" style="background-image: url({{ asset($user->header_bg_url) }})">
            <!-- Content -->
            <div id="profile-header__content">
                <!-- Avatar -->
                <div id="profile-header__avatar" style="background-image: url({{ asset($user->avatar_url) }})"></div>
                <!-- Title -->
                <h1 id="profile-header__title">{{ $user->formattedName }}</h1>
                <!-- Job title -->
                @if ($user->currentAssignment)
                    <h2 id="profile-header__subtitle">
                        {{ $user->currentAssignmentJobTitle }}
                    </h2>
                @endif
                <!-- Headline -->
                @if ($user->headline != "")
                    <h3 id="profile-header__headline">"{{ $user->headline }}"</h3>
                @endif
                <!-- Actions -->
                <div id="profile-header__actions">
                    <v-btn color="primary" href="{{ route('profile.update') }}">
                        @lang("tessify-core::profiles.profile_update_button")
                    </v-btn>
                </div>
            </div>    
            <!-- Overlay -->
            <div id="profile-header__overlay"></div>
        </div>

        <!-- Content wrapper -->
        <div class="content-section__wrapper">
            <div class="content-section pt50">

                <!-- Profile -->
                <div id="profile-content__wrapper">

                    <!-- Feedback -->
                    @include("tessify-core::partials.feedback")

                    <!-- Profile content -->
                    <div id="profile-content">
                        <div id="profile-content__left">

                            <!-- Account details -->
                            <h3 class="content-card__title">Persoonsgegevens</h3>
                            <div class="content-card mb elevation-1">
                                <div class="details mb-0">
                                    <div class="detail">
                                        <div class="key">@lang("tessify-core::profiles.profile_name")</div>
                                        <div class="val">{{ $user->formattedName }}</div>
                                    </div>
                                    <div class="detail">
                                        <div class="key">@lang("tessify-core::profiles.profile_email")</div>
                                        <div class="val">
                                            <span style="margin-right: 10px">{{ $user->email }}</span>
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

                            <!-- Interests -->
                            @if ($user->interests !== null and $user->interests !== "")
                                <h3 class="content-card__title">Interesses</h3>
                                <div class="content-card mb elevation-1">
                                    <div class="content-card__content">
                                        {!! nl2br($user->interests) !!}
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Assignments -->
                            <h3 class="content-card__title">Aanstellingen</h3>
                            <div class="content-card mb elevation-1">
                                <profile-assignment-list :assignments="{{ json_encode($assignments) }}"></profile-assignment-list>
                            </div>

                            <!-- Reviews -->
                            <h3 class="content-card__title">Recensies</h3>
                            <div class="content-card mb elevation-1">
                                <div class="content-card__content">
                                    Coming soon..
                                </div>
                            </div>

                            <!-- Reacties -->
                            <h3 class="content-card__title">Reacties</h3>
                            <div class="content-card mb elevation-1">
                                <div class="content-card__content">
                                    Coming soon..
                                </div>
                            </div>

                        </div>
                        <div id="profile-content__right">

                            <!-- Skills -->
                            <h3 class="content-card__title">Vaardigheden</h3>
                            <div class="content-card mb elevation-1">
                                <profile-skill-list :skills="{{ $user->skills->toJson() }}"></profile-skill-list>
                            </div>

                            <!-- Reputation -->
                            <h3 class="content-card__title">Reputatie</h3>
                            <div class="content-card elevation-1">
                                <div class="content-card__content">
                                    {{ number_format($user->reputation_points, 0, ".", ",") }} reputatie punten
                                </div>
                            </div>

                        </div>
                    </div>

                </div>  

            </div>
        </div>
    </div>
@stop