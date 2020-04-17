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
                <h2>@lang("tessify-core::get-started.task_features_title")</h2>
                <ul class="features">
                    <li class="feature">@lang("tessify-core::get-started.task_feature_one")</li>
                    <li class="feature">@lang("tessify-core::get-started.task_feature_two")</li>
                    <li class="feature">@lang("tessify-core::get-started.task_feature_three")</li>
                </ul>
                <div class="cta">
                    <v-btn color="primary" href="{{ route('tasks.create') }}" depressed>
                        <i class="fas fa-tasks"></i>
                        @lang("tessify-core::get-started.task_cta")
                    </v-btn>
                </div>
            </div>
            <div id="get-started__content-right">
                <h1>@lang("tessify-core::get-started.project_title")</h1>
                <div class="desc">@lang("tessify-core::get-started.project_description")</div>
                <h2>@lang("tessify-core::get-started.project_features_title")</h2>
                <ul class="features">
                    <li class="feature">@lang("tessify-core::get-started.project_feature_one")</li>
                    <li class="feature">@lang("tessify-core::get-started.project_feature_two")</li>
                    <li class="feature">@lang("tessify-core::get-started.project_feature_three")</li>
                </ul>
                <div class="cta">
                    <v-btn color="primary" href="{{ route('projects.create') }}" depressed>
                        <i class="fas fa-rocket"></i>
                        @lang("tessify-core::get-started.project_cta")
                    </v-btn>
                </div>
            </div>
        </div>

    </div>
@stop