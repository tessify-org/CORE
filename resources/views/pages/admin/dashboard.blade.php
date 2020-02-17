@extends("tessify-core::layouts.admin")

@section("breadcrumbs")
    {!! Breadcrumbs::render("admin.dashboard") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 class="page-title centered">Dashboard</h1>
        
            @include("tessify-core::partials.feedback")

            <div>Content goes here</div>

        </div>
    </div>
@stop