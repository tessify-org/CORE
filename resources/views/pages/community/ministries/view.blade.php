@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("ministries.view", $ministry) !!}
@stop

@section("content")
    <div id="ministry">

        <!-- Header -->
        <div id="ministry-header">
            <div id="ministry-header__overlay"></div>
            <div id="ministry-header__content">
                <div id="ministry-header__text">
                    <h1 id="ministry-header__title">{{ $ministry->name }}</h1>
                </div>
                <div id="ministry-header__actions">
                    @if (!Auth::user()->hasSubscribed($ministry))
                        <v-btn depressed href="{{ route('ministries.subscribe', ['slug' => $ministry->slug]) }}">
                            <i class="fas fa-check-circle"></i>
                            @lang("tessify-core::ministries.view_subscribe")
                        </v-btn>
                    @else
                        <v-btn depressed href="{{ route('ministries.unsubscribe', ['slug' => $ministry->slug]) }}">
                            <i class="fas fa-times-circle"></i>
                            @lang("tessify-core::ministries.view_unsubscribe")
                        </v-btn>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content -->
        <div id="ministry-content">
            <div class="content-section__wrapper">
                <div class="content-section">
                
                    <!-- Feedback -->
                    @include("tessify-core::partials.feedback")

                    <!-- Content -->
                    <div class="content-card elevation-1">
                        <div class="details">
                            <!-- Name -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::ministries.view_name")</div>
                                <div class="val">{{ $ministry->name }}</div> 
                            </div>
                            <!-- Abbreviation -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::ministries.view_abbreviation")</div>
                                <div class="val">{{ $ministry->abbreviation }}</div> 
                            </div>
                            <!-- Description -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::ministries.view_description")</div>
                                <div class="val">{{ $ministry->description }}</div> 
                            </div>
                            <!-- Website -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::ministries.view_website")</div>
                                <div class="val">
                                    <a href="{{ $ministry->website_url }}" target="_blank">
                                        {{ $ministry->website_url }}
                                    </a>
                                </div> 
                            </div>
                            <!-- Last updated on -->
                            <div class="detail">
                                <div class="key">@lang("tessify-core::ministries.view_last_update")</div>
                                <div class="val">{{ $ministry->updated_at->format("d-m-Y H:m:s") }}</div> 
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@stop