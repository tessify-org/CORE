@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("organizations") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title & subtitle -->
            <h1 class="page-title centered">@lang("tessify-core::organizations.title")</h1>
            <h2 class="page-subtitle centered">@lang("tessify-core::organizations.subtitle")</h2>
            
            <!-- Overview -->
            @if ($organizations->count())
                <div class="card-grid">
                    @foreach ($organizations as $organization)
                        <div class="card-wrapper">
                            <a class="card elevation-1" href="{{ route('organizations.view', $organization->slug) }}">
                                <span class="card-title">{{ $organization->name }}</span>
                                <span class="card-subtitle">{{ $organization->abbreviation }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-records elevation-1">
                    @lang("tessify-core::organizations.no_records")
                </div>
            @endif

        </div>
    </div>
@stop