@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("ministries") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title & subtitle -->
            <h1 class="page-title centered">@lang("tessify-core::ministries.title")</h1>
            <h2 class="page-subtitle centered">@lang("tessify-core::ministries.subtitle")</h2>

            <!-- Overview -->
            @if ($ministries->count())
                <div class="card-grid">
                    @foreach ($ministries as $ministry)
                        <div class="card-wrapper">
                            <a class="card elevation-1" href="{{ route('ministries.view', $ministry->slug) }}">
                                <span class="card-title">{{ $ministry->name }}</span>
                                <span class="card-subtitle">{{ $ministry->abbreviation }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-records elevation-1">
                    @lang("tessify-core::ministries.no_records")
                </div>
            @endif
            
        </div>
    </div>
@stop