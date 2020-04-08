@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("get-started") !!}
@stop

@section("content")
    <div id="get-started">

        <div id="get-started__bg">
            <div id="get-started__bg-left"></div>
            <div id="get-started__bg-right"></div>
        </div>

        <div id="get-started__content">
            <div id="get-started__content-left">
                <h1>@lang("tessify-core::get-started.task_title")</h1>
                <div class="desc">@lang("tessify-core::get-started.task_description")</div>
                <div class="cta">
                    <v-btn href="{{ route('tasks.create') }}" depressed>
                        @lang("tessify-core::get-started.task_cta")
                    </v-btn>
                </div>
            </div>
            <div id="get-started__content-right">
                <h1>@lang("tessify-core::get-started.project_title")</h1>
                <div class="desc">@lang("tessify-core::get-started.project_description")</div>
                <div class="cta">
                    <v-btn href="{{ route('projects.create') }}" depressed>
                        @lang("tessify-core::get-started.project_cta")
                    </v-btn>
                </div>
            </div>
        </div>

    </div>
@stop