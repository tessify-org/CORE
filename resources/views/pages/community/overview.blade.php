@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("community") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title & subtitle -->
            <h1 class="page-title centered">@lang("tessify-core::community.title")</h1>
            <h2 class="page-subtitle centered">@lang("tessify-core::community.subtitle")</h2>
            
            <!-- Content -->
            <div id="community-links" class="card-grid">
                <!-- Memberlist -->
                <div class="card-wrapper">
                    <a class="card elevation-1" href="{{ route('memberlist') }}">
                        <span class="card-icon">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="card-title">
                            @lang("tessify-core::community.memberlist")
                        </span>
                    </a>
                </div>
                <!-- Ministries -->
                <div class="card-wrapper">
                    <a class="card elevation-1" href="{{ route('ministries') }}">
                        <span class="card-icon">
                            <i class="fas fa-chess-rook"></i>
                        </span>
                        <span class="card-title">
                            @lang("tessify-core::community.ministries")
                        </span>
                    </a>
                </div>
                <!-- Organizations -->
                <div class="card-wrapper">
                    <a class="card elevation-1" href="{{ route('organizations') }}">
                        <span class="card-icon">
                            <i class="fas fa-building"></i>
                        </span>
                        <span class="card-title">
                            @lang("tessify-core::community.organizations")
                        </span>
                    </a>
                </div>
            </div>

        </div>
    </div>
@stop