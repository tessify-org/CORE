<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>NNW @yield('page_title')</title>
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        {{-- Laravel Mix - CSS File --}}
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        {{-- Font Awesome --}}
        <script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js" integrity="sha384-DJ25uNYET2XCl5ZF++U8eNxPWqcKohUUBUpKGlNLMchM7q4Wjg2CUpjHLaL8yYPH" crossorigin="anonymous"></script>
    </head>
    <body>

        <v-app id="app" class="@if(Request::is('/')) home @endif" v-cloak>

            <!-- Topnav -->
            <div id="topnav__wrapper">
                <div id="topnav">

                    <!-- Logo -->
                    <div id="topnav-logo__wrapper">
                        <a id="topnav-logo" href="{{ route('home') }}">
                            N<sup>2</sup>W
                        </a>
                    </div>

                    <!-- Locale switcher -->
                    <div id="topnav-locale__wrapper">
                        <locale-switcher 
                            active-locale="{{ $activeLocale }}"
                            :locales="{{ json_encode($locales) }}"
                            endpoint="{{ route('api.locale.set-active.post') }}"
                            :light="{{ Request::is('/') ? json_encode(true) : json_encode(false) }}">
                        </locale-switcher>
                    </div>

                    <div id="topnav-search__wrapper">
                        <topnav-search-button
                            href="{{ route('search') }}">
                        </topnav-search-button>
                    </div>

                    <!-- Navigation -->
                    <nav id="topnav-links__wrapper">
                        <ul id="topnav-links">
                            @if (!Auth::check())
                                <!-- Register -->
                                <li class="topnav-link__wrapper">
                                    <a class="topnav-link" href="{{ route('auth.register') }}">
                                        @lang("tessify-core::layouts.register_link")
                                    </a>
                                </li>
                                <!-- Login -->
                                <li class="topnav-link__wrapper">
                                    <a class="topnav-link" href="{{ route('auth.login') }}">
                                        @lang("tessify-core::layouts.login_link")
                                    </a>
                                </li>
                            @else
                                <!-- Dashboard -->
                                <li class="topnav-link__wrapper">
                                    <a class="topnav-link" href="{{ route('dashboard') }}">
                                        @lang("tessify-core::layouts.dashboard_link")
                                    </a>
                                </li>
                                <!-- Jobs -->
                                <li class="topnav-link__wrapper">
                                    <a class="topnav-link" href="{{ route('tasks') }}">
                                        @lang("tessify-core::layouts.tasks_link")
                                    </a>
                                </li>
                                <!-- Projects -->
                                <li class="topnav-link__wrapper">
                                    <a class="topnav-link" href="{{ route('projects') }}">
                                        @lang("tessify-core::layouts.projects_link")
                                    </a>
                                </li>
                                <!-- Community -->
                                <li class="topnav-link__wrapper with-dropdown">
                                    <a class="topnav-link" href="{{ route('community') }}">
                                        @lang("tessify-core::layouts.community_link")
                                        <span class="dropdown-caret">
                                            <i class="fas fa-caret-down"></i>
                                        </span>
                                    </a>
                                    <ul class="dropdown">
                                        <!-- Members -->
                                        <li class="dropdown-link__wrapper">
                                            <a class="dropdown-link" href="{{ route('memberlist') }}">
                                                @lang("tessify-core::layouts.members_link")
                                            </a>
                                        </li>
                                        <!-- Ministries -->
                                        <li class="dropdown-link__wrapper">
                                            <a class="dropdown-link" href="{{ route('ministries') }}">
                                                @lang("tessify-core::layouts.ministries_link")
                                            </a>
                                        </li>
                                        <!-- Organizations -->
                                        <li class="dropdown-link__wrapper">
                                            <a class="dropdown-link" href="{{ route('organizations') }}">
                                                @lang("tessify-core::layouts.organizations_link")
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- User -->
                                <li class="topnav-link__wrapper with-dropdown">
                                    <a class="topnav-link" href="#">
                                        {{ $user->formattedName }}
                                        <img id="avatar" src="{{ asset($user->avatar_url) }}">
                                        <span class="dropdown-caret">
                                            <i class="fas fa-caret-down"></i>
                                        </span>
                                    </a>
                                    <ul class="dropdown">
                                        <li class="dropdown-link__wrapper">
                                            <a class="dropdown-link" href="{{ route('profile') }}">
                                                <span class="dropdown-link__icon"><i class="fas fa-id-badge"></i></span>
                                                <span class="dropdown-link__text">@lang("tessify-core::layouts.profile_link")</span>
                                            </a>
                                        </li>
                                        <!-- <li class="dropdown-link__wrapper">
                                            <a class="dropdown-link" href="{{ route('profile.update') }}">
                                                <span class="dropdown-link__icon"><i class="fas fa-user-edit"></i></span>
                                                <span class="dropdown-link__text">@lang("tessify-core::layouts.edit_profile_link")</span>
                                            </a>
                                        </li> -->
                                        <li class="dropdown-link__wrapper">
                                            <a class="dropdown-link" href="{{ route('messages') }}">
                                                <span class="dropdown-link__icon"><i class="fas fa-envelope"></i></span>
                                                <span class="dropdown-link__text">@lang("tessify-core::layouts.messages_link")</span>
                                            </a>
                                        </li>
                                        <li class="dropdown-link__wrapper">
                                            <a class="dropdown-link" href="{{ route('notifications') }}">
                                                <span class="dropdown-link__icon"><i class="fas fa-flag"></i></span>
                                                <span class="dropdown-link__text">@lang("tessify-core::layouts.notifications_link")</span>
                                            </a>
                                        </li>
                                        <li class="dropdown-link__wrapper">
                                            <a class="dropdown-link" href="{{ route('settings') }}">
                                                <span class="dropdown-link__icon"><i class="fas fa-cog"></i></span>
                                                <span class="dropdown-link__text">@lang("tessify-core::layouts.settings_link")</span>
                                            </a>
                                        </li>
                                        @can("access-admin-panel")
                                            <li class="dropdown-link__wrapper">
                                                <a class="dropdown-link" href="{{ route('admin.dashboard') }}">
                                                    <span class="dropdown-link__icon"><i class="fas fa-crown"></i></span>
                                                    <span class="dropdown-link__text">@lang("tessify-core::layouts.admin_link")</span>
                                                </a>
                                            </li>
                                        @endcan
                                        <li class="dropdown-link__wrapper">
                                            <a class="dropdown-link" href="{{ route('auth.logout') }}">
                                                <span class="dropdown-link__icon"><i class="fas fa-sign-out-alt"></i></span>
                                                <span class="dropdown-link__text">@lang("tessify-core::layouts.logout_link")</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- 
                                @if (Auth::check())
                                    <div id="topnav-avatar">
                                        <img id="avatar" src="{{ is_null($user->avatar_url) ? Avatar::create($user->combinedName)->toBase64() : $user->avatar_url }}" />
                                    </div>
                                @endif
                                -->
                            @endif
                        </ul>
                        <div id="mobile-nav-button">
                            <hamburger-button></hamburger-button>
                        </div>
                    </nav>

                    <!-- Topnav buttons -->
                    @if (Auth::check())
                        <div id="topnav-buttons">
                            <!-- Unread notifications -->
                            <div class="topnav-button">
                                <topnav-unread-notifications 
                                    href="{{ route('notifications') }}"
                                    count="{{ $numUnreadNotifications }}"
                                    :light="{{ Request::is('/') ? json_encode(true) : json_encode(false) }}">
                                </topnav-unread-notifications>
                            </div>
                            <!-- Unread messages -->
                            <div class="topnav-button">
                                <topnav-unread-messages 
                                    count="{{ $numUnreadMessages }}"
                                    href="{{ route('messages') }}"
                                    :light="{{ Request::is('/') ? json_encode(true) : json_encode(false) }}">
                                </topnav-unread-messages>
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>

            <!-- Mobile navigation -->
            <mobile-navigation>
                <a class="sidemenu-link" href="{{ route('home') }}">
                    <span class="sidemenu-link__text">
                        Home
                    </span>
                </a>
                @if (Auth::check())
                    <a class="sidemenu-link" href="{{ route('projects') }}">
                        <span class="sidemenu-link__text">
                            @lang("tessify-core::layouts.projects_link")
                        </span>
                    </a>
                    <a class="sidemenu-link" href="{{ route('memberlist') }}">
                        <span class="sidemenu-link__text">
                            @lang("tessify-core::layouts.members_link")
                        </span>
                    </a>
                    <a class="sidemenu-link" href="{{ route('profile') }}">
                        <span class="sidemenu-link__text">
                            @lang("tessify-core::layouts.profile_link")
                        </span>
                    </a>
                    @can("access-admin-panel")
                        <a class="sidemenu-link" href="{{ route('admin.dashboard') }}">
                            <span class="sidemenu-link__text">
                                @lang("tessify-core::layouts.admin_link")
                            </span>
                        </a>
                    @endcan
                    <a class="sidemenu-link" href="{{ route('auth.logout') }}">
                        <span class="sidemenu-link__text">
                            @lang("tessify-core::layouts.logout_link")
                        </span>
                    </a>
                @else
                    <a class="sidemenu-link" href="{{ route('auth.login') }}">
                        <span class="sidemenu-link__text">
                            @lang("tessify-core::layouts.login_link")
                        </span>
                    </a>
                    <a class="sidemenu-link" href="{{ route('auth.register') }}">
                        <span class="sidemenu-link__text">
                            @lang("tessify-core::layouts.register_link")
                        </span>
                    </a>
                @endif
            </mobile-navigation>

            <!-- Breadcrumbs -->
            @if (!Request::is('/'))
                @yield("breadcrumbs")
            @endif

            <!-- Content -->
            <div id="content__wrapper">
                @yield("content")
            </div>

            <!-- Footer -->
            <footer id="footer__wrapper">
                <div id="footer">
                    <div id="footer-upper">
                        <div class="footer-upper__column-wrapper">
                            <div class="footer-upper__column">
                                <h4 class="column-title">
                                    @lang("tessify-core::layouts.footer_first_column_title")
                                </h4>
                                <div class="column-links">
                                    <a class="column-link" href="{{ route('press') }}">
                                        @lang("tessify-core::layouts.footer_press_link")
                                    </a>
                                    <a class="column-link" href="{{ route('partners') }}">
                                        @lang("tessify-core::layouts.footer_partners_link")
                                    </a>
                                    <a class="column-link" href="{{ route('about') }}">
                                        @lang("tessify-core::layouts.footer_about_link")
                                    </a>
                                    <a class="column-link" href="{{ route('do-more') }}">
                                        @lang("tessify-core::layouts.footer_do_more_link")
                                    </a>
                                    <a class="column-link" href="{{ route('faq') }}">
                                        @lang("tessify-core::layouts.footer_faq_link")
                                    </a>
                                    <a class="column-link" href="{{ route('contact') }}">
                                        @lang("tessify-core::layouts.footer_contact_link")
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-upper__column-wrapper">
                            <div class="footer-upper__column">
                                <h4 class="column-title">
                                    @lang("tessify-core::layouts.footer_second_column_title")
                                </h4>
                                <div class="column-links">
                                    <a class="column-link" href="#">
                                        @lang("tessify-core::layouts.footer_financial_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("tessify-core::layouts.footer_employer_downloads_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("tessify-core::layouts.footer_employer_do_more_link")
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-upper__column-wrapper">
                            <div class="footer-upper__column">
                                <h4 class="column-title">
                                    @lang("tessify-core::layouts.footer_third_column_title")
                                </h4>
                                <div class="column-links">
                                    <a class="column-link" href="#">
                                        @lang("tessify-core::layouts.footer_group_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("tessify-core::layouts.footer_employee_downloads_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("tessify-core::layouts.footer_employee_do_more_link")
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-upper__column-wrapper">
                            <div class="footer-upper__column">
                                <h4 class="column-title">
                                    @lang("tessify-core::layouts.footer_newsletter_title")
                                </h4>
                                <div class="column-text">
                                    @lang("tessify-core::layouts.footer_newsletter_text")
                                </div>
                                <newsletter-signup-form
                                    submit-text="@lang('tessify-core::layouts.newsletter_signup_submit')"
                                    signed-up-text="@lang('tessify-core::layouts.newsletter_signed_up')"
                                    api-endpoint="{{ route('api.newsletter.signup.post') }}">
                                </newsletter-signup-form>
                            </div>
                        </div>
                    </div>
                    <div id="footer-bottom">
                        <div id="footer-bottom__left">
                            @lang("tessify-core::layouts.footer_copyright")
                        </div>
                        <div id="footer-bottom__right">
                            <a href="#" class="footer-bottom-link">
                                @lang("tessify-core::layouts.footer_cookies_link")
                            </a>
                            <a href="#" class="footer-bottom-link">
                                @lang("tessify-core::layouts.footer_disclaimer_link")
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
            
            <!-- Bug report -->
            <div id="bug-report-button__wrapper">
                <bug-report-button
                    url="{{ url()->current() }}"
                    dialog-title-text="@lang('tessify-core::bugreports.dialog_title')"
                    cancel-text="@lang('tessify-core::bugreports.dialog_cancel')"
                    submit-text="@lang('tessify-core::bugreports.dialog_submit')"
                    form-action="{{ route('submit-bug-report.post') }}"
                    csrf-token="{{ csrf_token() }}"
                    url-label-text="@lang('tessify-core::bugreports.dialog_form_url_label')"
                    severity-label-text="@lang('tessify-core::bugreports.dialog_form_severity_label')"
                    low-severity-text="@lang('tessify-core::bugreports.severity_low')"
                    medium-severity-text="@lang('tessify-core::bugreports.severity_medium')"
                    high-severity-text="@lang('tessify-core::bugreports.severity_high')"
                    report-label-text="@lang('tessify-core::bugreports.dialog_form_report_label')">
                </bug-report-button>
            </div>

        </v-app>

        {{-- Laravel Mix - JS File --}}
        <script src="{{ mix('js/app.js') }}"></script>

    </body>
</html>
