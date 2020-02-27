@extends("tessify-core::layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("projects.tasks.view", $project, $task) !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <!-- Title -->
            <h1 class="page-title centered">@lang("tessify-core::tasks.view_title")</h1>
            
            <!-- Application -->
            <div id="task__wrapper">
                
                <!-- Content -->
                <div id="task">

                    <!-- Feedback -->
                    @include("tessify-core::partials.feedback")

                    <!-- Details -->
                    <div class="elevation-1">

                        <!-- Details -->
                        <div class="details">
                            <div class="detail">
                                <div class="key">ID</div>
                                <div class="val">{{ $task->id }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">Status</div>
                                <div class="val">{{ $task->status->label }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">Category</div>
                                <div class="val">{{ $task->category->name }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">Seniority</div>
                                <div class="val">{{ $task->seniority->label }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">Title</div>
                                <div class="val">{{ $task->title }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">Description</div>
                                <div class="val">{{ $task->description }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">Complexitity</div>
                                <div class="val">{{ $task->complexity }} / 10</div>
                            </div>
                            <div class="detail">
                                <div class="key">Estimated hours</div>
                                <div class="val">{{ $task->estimated_hours }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">Realized hours</div>
                                <div class="val">{{ $task->realized_hours }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">Number of positions</div>
                                <div class="val">{{ $task->num_positions }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">Users</div>
                                <div class="val">
                                    @if ($task->users->count())
                                        <ul>
                                            @foreach ($task->users as $user)
                                                <li>{{ $user->formattedName }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        No users
                                    @endif
                                </div>
                            </div>
                            <div class="detail">
                                <div class="key">Skills</div>
                                <div class="val">
                                    @if ($task->skills->count())
                                        <ul>
                                            @foreach ($task->skills as $skill)
                                                <li>
                                                    {{ $skill->name }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        No required skills
                                    @endif
                                </div>
                            </div>
                            <div class="detail">
                                <div class="key">Created at</div>
                                <div class="val">{{ $task->created_at->format("d-m-Y") }}</div>
                            </div>
                            <div class="detail">
                                <div class="key">Updated at</div>
                                <div class="val">{{ $task->updated_at->format("d-m-Y") }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Controls -->
                    <div class="form-controls">
                        @canany(["update", "delete"], $task)
                            <div class="form-controls__left">
                                @can("update", $task)
                                    <v-btn color="warning" href="{{ route('projects.tasks.edit', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}">
                                        <i class="fas fa-edit"></i>
                                        @lang("tessify-core::general.edit")
                                    </v-btn>
                                @endcan
                                @can("delete", $task)
                                    <v-btn color="red" dark href="{{ route('projects.tasks.delete', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}">
                                        <i class="fas fa-trash-alt"></i>
                                        @lang("tessify-core::general.delete")
                                    </v-btn>
                                @endcan
                            </div>
                        @endcanany
                        @canany(["assign-to-self", "abandon"], $task)
                            <div class="form-controls__right">
                                @can("assign-to-self", $task)
                                    <v-btn color="primary" href="{{ route('projects.tasks.assign-to-me', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}">
                                        <i class="fas fa-user-plus"></i>
                                        @lang("tessify-core::tasks.view_assign_to_self")
                                    </v-btn>
                                @endcan
                                @can("abandon", $task)
                                    <v-btn color="red" dark href="{{ route('projects.tasks.abandon', ['slug' => $project->slug, 'taskSlug' => $task->slug]) }}">
                                        <i class="fas fa-user-minus"></i>
                                        @lang("tessify-core::tasks.view_abandon")
                                    </v-btn>
                                @endcan
                            </div>
                        @endcanany
                    </div>
                    
                </div>

            </div>

        </div>
    </div>
@stop