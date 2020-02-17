@if (count($breadcrumbs) > 0)
    <div id="breadcrumbs-wrapper">
        <ul id="breadcrumbs">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && $loop->remaining)
                    <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb->url }}">
                            @if ($loop->first)
                                <span class="home">
                                    @if (isset($home_icon))
                                        {!! $home_icon !!}
                                    @else
                                        <i class="fas fa-home"></i>
                                    @endif
                                </span>
                            @endif
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                    <li class="breadcrumb-item chevron">
                        <i class="fas fa-chevron-right"></i>
                    </li>
                @else
                    <li class="breadcrumb-item active">
                        @if ($loop->first)
                            <span class="home">
                                @if (isset($home_icon))
                                    {!! $home_icon !!}
                                @else
                                    <i class="fas fa-home"></i>
                                @endif
                            </span>
                        @endif
                        {{ $breadcrumb->title }}
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif