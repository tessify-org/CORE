@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("ministries.view", $ministry) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">{{ $ministry->name }}</h1>
            
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
@stop