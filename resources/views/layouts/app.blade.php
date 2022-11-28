<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Project') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/users.css') }}">
    <link href="{{ asset('css/news.css') }}" rel="stylesheet" type="text/css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>
    <div id="app">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="{{route('guest.dash')}}">Laravel App</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if (!is_null(Auth::user()->avatar))
                                <img src="{{ Storage::url(Auth::user()->avatar) }}" width="30" class="rounded-circle">
                                @else
                                <img src="{{ Storage::url('avatars/null.jpg') }}" width="30" class="rounded-circle">
                                @endif
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <!--If user is an admin then render this...-->
                                @if (Auth::user()->role === 1)
                                <a class="dropdown-item" href="{{ route('admin.dash') }}">
                                    {{ __('Admin') }}
                                </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('profile', Auth::user()->id) }}">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
            <!-- Navbar-->

        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            @auth
                            <div class="sb-sidenav-menu-heading"><i class="fa-solid fa-user"></i> <b>{{Auth::user()->name}}</b></div>
                                @if (Auth::user()->role === 1)
                                <div class="sb-sidenav-menu-heading">Admin</div>
                                <a class="nav-link" href="{{ route('admin.dash') }}">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                                    {{ __('Admin dashboard') }}
                                </a>
                                @endif
                            @endauth
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="{{route('guest.dash')}}">
                                <div class="sb-nav-link-icon"><i class="fa-sharp fa-solid fa-house"></i></div>
                                {{ __('Home') }}
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-question"></i></div>
                                {{ __('FAQ') }}
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{route('faqView')}}">{{ __('Frequently asked questions') }}</a>
                                    <!-- <a class="nav-link" href="{{route('faqForm')}}">{{ __('Ask a question') }}</a> -->
                                </nav>
                            </div>
                            <a class="nav-link" href="{{route('about')}}">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-info"></i></div>
                                {{ __('About') }}
                                
                            </a>
                            <a class="nav-link" href="{{route('contactView')}}">
                                <div class="sb-nav-link-icon"><i class="fa-sharp fa-solid fa-file-signature"></i></div>
                                {{ __('Contact us') }}
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <!-- HERE COMES PAGES CONTENT -->
                @yield('content')
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Made by Jean</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>



        <!-- <main class="py-4"></main> -->

    </div>

    <script src="{{ asset('js/scripts.js') }}"></script>
            <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
</body>

</html>