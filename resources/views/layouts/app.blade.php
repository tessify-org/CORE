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
                    <!-- Search -->
                    <div id="topnav-search__wrapper">
                        <form action="{{ route('search.post') }}" method="post">
                            {{ csrf_field() }}
                            <div id="topnav-search">
                                <input type="text" id="topnav-search__input" name="query" placeholder="Zoeken..">
                                <button type="submit" id="topnav-search__submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Navigation -->
                    <nav id="topnav-links__wrapper">
                        <ul id="topnav-links">
                            @if (!Auth::check())
                                <!-- Login -->
                                <li class="topnav-link__wrapper">
                                    <a class="topnav-link" href="{{ route('auth.login') }}">
                                        @lang("layouts.login_link")
                                    </a>
                                </li>
                                <!-- Register -->
                                <li class="topnav-link__wrapper">
                                    <a class="topnav-link" href="{{ route('auth.register') }}">
                                        @lang("layouts.register_link")
                                    </a>
                                </li>
                            @else
                                <!-- Jobs -->
                                <li class="topnav-link__wrapper">
                                    <a class="topnav-link" href="{{ route('projects') }}">
                                        @lang("layouts.projects_link")
                                    </a>
                                </li>
                                <!-- Members -->
                                <li class="topnav-link__wrapper">
                                    <a class="topnav-link" href="{{ route('memberlist') }}">
                                        @lang("layouts.members_link")
                                    </a>
                                </li>
                                <!-- My profile -->
                                <li class="topnav-link__wrapper">
                                    <a class="topnav-link" href="{{ route('profile') }}">
                                        @lang("layouts.profile_link")
                                    </a>
                                </li>
                                @can("access-admin-panel")
                                    <li class="topnav-link__wrapper">
                                        <a class="topnav-link" href="{{ route('admin.dashboard') }}">
                                            @lang("layouts.admin_link")
                                        </a>
                                    </li>
                                @endcan
                                <!-- Logout -->
                                <li class="topnav-link__wrapper">
                                    <a class="topnav-link" href="{{ route('auth.logout') }}">
                                        @lang("layouts.logout_link")
                                    </a>
                                </li>
                            @endif
                        </ul>
                        @if (Auth::check())
                            <div id="topnav-avatar">
                                <img id="avatar" src="{{ is_null($user->avatar_url) ? Avatar::create($user->combinedName)->toBase64() : $user->avatar_url }}" />
                            </div>
                        @endif
                        <div id="mobile-nav-button">
                            <hamburger-button></hamburger-button>
                        </div>
                    </nav>
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
                            @lang("layouts.projects_link")
                        </span>
                    </a>
                    <a class="sidemenu-link" href="{{ route('memberlist') }}">
                        <span class="sidemenu-link__text">
                            @lang("layouts.members_link")
                        </span>
                    </a>
                    <a class="sidemenu-link" href="{{ route('profile') }}">
                        <span class="sidemenu-link__text">
                            @lang("layouts.profile_link")
                        </span>
                    </a>
                    @can("access-admin-panel")
                        <a class="sidemenu-link" href="{{ route('admin.dashboard') }}">
                            <span class="sidemenu-link__text">
                                @lang("layouts.admin_link")
                            </span>
                        </a>
                    @endcan
                    <a class="sidemenu-link" href="{{ route('auth.logout') }}">
                        <span class="sidemenu-link__text">
                            @lang("layouts.logout_link")
                        </span>
                    </a>
                @else
                    <a class="sidemenu-link" href="{{ route('auth.login') }}">
                        <span class="sidemenu-link__text">
                            @lang("layouts.login_link")
                        </span>
                    </a>
                    <a class="sidemenu-link" href="{{ route('auth.register') }}">
                        <span class="sidemenu-link__text">
                            @lang("layouts.register_link")
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
                                    @lang("layouts.footer_first_column_title")
                                </h4>
                                <div class="column-links">
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_press_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_partners_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_about_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_do_more_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_faq_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_contact_link")
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-upper__column-wrapper">
                            <div class="footer-upper__column">
                                <h4 class="column-title">
                                    @lang("layouts.footer_second_column_title")
                                </h4>
                                <div class="column-links">
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_financial_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_employer_downloads_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_employer_do_more_link")
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-upper__column-wrapper">
                            <div class="footer-upper__column">
                                <h4 class="column-title">
                                    @lang("layouts.footer_third_column_title")
                                </h4>
                                <div class="column-links">
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_group_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_employee_downloads_link")
                                    </a>
                                    <a class="column-link" href="#">
                                        @lang("layouts.footer_employee_do_more_link")
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-upper__column-wrapper">
                            <div class="footer-upper__column">
                                <h4 class="column-title">
                                    @lang("layouts.footer_newsletter_title")
                                </h4>
                                <div class="column-text">
                                    @lang("layouts.footer_newsletter_text")
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="footer-bottom">
                        <div id="footer-bottom__left">
                            @lang("layouts.footer_copyright")
                        </div>
                        <div id="footer-bottom__right">
                            <a href="#" class="footer-bottom-link">
                                @lang("layouts.footer_cookies_link")
                            </a>
                            <a href="#" class="footer-bottom-link">
                                @lang("layouts.footer_disclaimer_link")
                            </a>
                        </div>
                    </div>
                </div>
            </footer>

        </v-app>

        {{-- Laravel Mix - JS File --}}
        <script src="{{ mix('js/app.js') }}"></script>

    </body>
</html>