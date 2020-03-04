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
        <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
        {{-- Font Awesome --}}
        <script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js" integrity="sha384-DJ25uNYET2XCl5ZF++U8eNxPWqcKohUUBUpKGlNLMchM7q4Wjg2CUpjHLaL8yYPH" crossorigin="anonymous"></script>
    </head>
    <body>

        <v-app id="app" class="@if(Request::is('/')) home @endif">

            <!-- Topnav -->
            <div id="topnav__wrapper">
                <div id="topnav">
                    <!-- Logo -->
                    <div id="topnav-logo__wrapper">
                        <a id="topnav-logo" href="{{ route('home') }}">
                            N<sup>2</sup>W
                        </a>
                    </div>
                    <!-- Navigation -->
                    <nav id="topnav-links__wrapper">
                        <ul id="topnav-links">
                            <!-- Back to frontend -->
                            <li class="topnav-link__wrapper">
                                <a class="topnav-link" href="{{ route('home') }}">
                                    Terug naar de voorkant
                                </a>
                            </li>
                        </ul>
                        <div id="mobile-nav-button">
                            <hamburger-button></hamburger-button>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Mobile navigation -->
            <mobile-navigation>
                @if (Auth::check())
                    <a class="sidemenu-link" href="{{ route('admin.dashboard') }}">
                        <span class="sidemenu-link__text">Dashboard</div>
                    </a>
                    <a class="sidemenu-link" href="{{ route('home') }}">
                        <span class="sidemenu-link__text">Naar de frontend</div>
                    </a>
                    </a>
                    <a class="sidemenu-link" href="{{ route('auth.logout') }}">
                        <span class="sidemenu-link__text">Uitloggen</div>
                    </a>
                @else
                    <a class="sidemenu-link" href="{{ route('auth.login') }}">
                        <span class="sidemenu-link__text">Login</div>
                    </a>
                    <a class="sidemenu-link" href="{{ route('auth.register') }}">
                        <span class="sidemenu-link__text">Registeren</div>
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
                                <h4 class="column-title">HNNW</h4>
                                <div class="column-links">
                                    <a class="column-link" href="#">Pers</a>
                                    <a class="column-link" href="#">Partners</a>
                                    <a class="column-link" href="#">Over HNNW</a>
                                    <a class="column-link" href="#">Meer doen</a>
                                    <a class="column-link" href="#">Veelgestelde vragen</a>
                                    <a class="column-link" href="#">Contact</a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-upper__column-wrapper">
                            <div class="footer-upper__column">
                                <h4 class="column-title">Voor klusaanbieders</h4>
                                <div class="column-links">
                                    <a class="column-link" href="#">Financiele bijdragen</a>
                                    <a class="column-link" href="#">Downloads</a>
                                    <a class="column-link" href="#">Meer doen als klusaanbieder</a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-upper__column-wrapper">
                            <div class="footer-upper__column">
                                <h4 class="column-title">Voor klusaannemers</h4>
                                <div class="column-links">
                                    <a class="column-link" href="#">Meedoen als groep</a>
                                    <a class="column-link" href="#">Downloads</a>
                                    <a class="column-link" href="#">Meer doen als vrijwilleger</a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-upper__column-wrapper">
                            <div class="footer-upper__column">
                                <h4 class="column-title">Nieuwsbrief</h4>
                                <div class="column-text">
                                    Meld je aan voor de maandelijkse digitale nieuwsbrief.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="footer-bottom">
                        <div id="footer-bottom__left">
                            &copy; Copyrighted by yours truly. This is the way. 2020 - &infin;
                        </div>
                        <div id="footer-bottom__right">
                            <a href="#" class="footer-bottom-link">
                                Cookies en privacy
                            </a>
                            <a href="#" class="footer-bottom-link">
                                Disclaimer
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