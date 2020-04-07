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
                <h1>Create a new task</h1>
                <div class="desc">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus tristique odio nisi, quis tempus purus ultricies eu. Donec ac hendrerit lacus, mollis luctus velit. Cras vitae venenatis urna. Cras varius felis aliquam auctor malesuada.
                </div>
                <div class="cta">
                    <v-btn href="{{ route('tasks.create') }}" depressed>
                        Create a task
                    </v-btn>
                </div>
            </div>
            <div id="get-started__content-right">
                <h1>Create a new project</h1>
                <div class="desc">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus tristique odio nisi, quis tempus purus ultricies eu. Donec ac hendrerit lacus, mollis luctus velit. Cras vitae venenatis urna. Cras varius felis aliquam auctor malesuada.
                </div>
                <div class="cta">
                    <v-btn href="{{ route('projects.create') }}" depressed>
                        Create a project
                    </v-btn>
                </div>
            </div>
        </div>

    </div>
@stop