@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("search") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::search.title")</h1>
        
            <!-- Feedback -->
            @include("tessify-core::partials.feedback")
            
            <!-- Search form -->
            <!-- <form action="{{ route('search.post') }}" method="post">
                @csrf
                <v-text-field name="search_query" solo></v-text-field>
                <v-btn type="submit">Search</v-btn>
            </form> -->

            <!-- Search results -->
            <search-results
                api-endpoint="{{ route('api.search.post') }}"
                search-query="{{ $query }}"
                search-placeholder-text="@lang('tessify-core::search.search_placeholder')"
                no-results-text="@lang('tessify-core::search.no_results')"
                enter-query-text="@lang('tessify-core::search.enter_query')"
                user-type-text="@lang('tessify-core::search.user_type')"
                task-type-text="@lang('tessify-core::search.task_type')"
                project-type-text="@lang('tessify-core::search.project_type')"
                ministry-type-text="@lang('tessify-core::search.ministry_type')"
                organization-type-text="@lang('tessify-core::search.organization_type')"
                results-text="@lang('tessify-core::search.results')">
            </search-results>

        </div>
    </div>
@stop