<div id="messages-sidebar" class="elevation-1">
    <ul id="messages-nav">
        <!-- Inbox -->
        <li class="messages-nav__link-wrapper">
            <a class="messages-nav__link @if($page == 'inbox') active @endif" href="{{ route('messages') }}">
                @lang("tessify-core::messages.nav_inbox")
            </a>
        </li>
        <!-- Outbox -->
        <li class="messages-nav__link-wrapper">
            <a class="messages-nav__link @if($page == 'outbox') active @endif" href="{{ route('messages.outbox') }}">
                @lang("tessify-core::messages.nav_outbox")
            </a>
        </li>
        <!-- Send message -->
        <li class="messages-nav__link-wrapper">
            <a class="messages-nav__link @if($page == 'send') active @endif" href="{{ route('messages.send') }}">
                @lang("tessify-core::messages.nav_send")
            </a>
        </li>
    </ul>
</div>