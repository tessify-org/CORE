 <!-- Flash messages -->
@if (session('flash_notification', collect())->count() > 0)

    <!-- Conditional wrapper (open) -->
    @if (isset($wrapper) and $wrapper)
        <div class="alert-wrapper">
    @endif

        <!-- Flash messages -->
        @foreach (session('flash_notification', collect())->toArray() as $message)
            <div class="elevation-1 alert alert-{{ $message['level'] }} {{ $message['important'] ? 'alert-important' : '' }}" role="alert">
                {!! $message['message'] !!}
            </div>
        @endforeach
    
    <!-- Conditional wrapper (close) -->
    @if (isset($wrapper) and $wrapper)
        </div>
    @endif

    <!-- Forget the message so it disappears (on the next request) after being shown -->
    {{ session()->forget('flash_notification') }}

@endif