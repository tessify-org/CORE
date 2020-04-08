@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("memberlist") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 id="memberlist-title" class="page-title centered">
                @lang("tessify-core::profiles.memberlist_title")
            </h1>

            <!-- Feedback -->
            @include("tessify-core::partials.feedback")

            <!-- Memberlist -->
            <memberlist
                :users="{{ $users->toJson() }}"
                :ministries="{{ $ministries->toJson() }}"
                :organizations="{{ $organizations->toJson() }}"
                name-text="@lang('tessify-core::profiles.memberlist_name')"
                reputation-text="@lang('tessify-core::profiles.memberlist_reputation')"
                no-records-text="@lang('tessify-core::profiles.memberlist_no_users')"
                points-text="@lang('tessify-core::profiles.memberlist_points')"
                search-text="@lang('tessify-core::profiles.memberlist_search')"
                ministry-text="@lang('tessify-core::profiles.memberlist_ministry')"
                organization-text="@lang('tessify-core::profiles.memberlist_organization')">
            </memberlist>

        </div>
    </div>
@stop