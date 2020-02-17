@extends("layouts.app")

@section("breadcrumbs")
    {!! Breadcrumbs::render("memberlist") !!}
@stop

@section("content")
    <div class="content-section__wrapper">
        <div class="content-section">

            <h1 id="memberlist-title" class="page-title centered">
                @lang("tessify-core::profiles.memberlist_title")
            </h1>
        
            @include("partials.feedback")

            @if ($users->count())
                <div id="memberlist" class="elevation-1">
                    <div id="memberlist__header">
                        <div class="memberlist__header-column">
                            @lang("tessify-core::profiles.memberlist_name")
                        </div>
                        <div class="memberlist__header-column">
                            @lang("tessify-core::profiles.memberlist_reputation")
                        </div>
                    </div>
                    <div id="memberlist__content">
                        @foreach ($users as $user)
                            <a class="member" href="{{ route('profile', $user->slug) }}">
                                <div class="member-name">
                                    {{ $user->formattedName }}
                                </div>
                                <div class="member-reputation">
                                    Excellent
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <div id="no-members">
                    @lang("tessify-core::profiles.memberlist_no_users")
                </div>
            @endif

        </div>
    </div>
@stop