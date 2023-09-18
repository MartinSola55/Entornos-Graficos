@php
    use Carbon\Carbon;
    $today = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- You can change the theme colors from here -->
    <link rel="stylesheet" href="{{ asset('css/colors/default-dark.css') }}">
    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- Popup CSS -->
    <link href="{{ asset('plugins/Magnific-Popup-master/dist/magnific-popup.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('plugins/popper/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <!--stickey kit -->
    <script src="{{ asset('plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{ asset('plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
    <!-- Notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Magnific popup JavaScript -->
    <script src="{{ asset('plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') }}"></script>
</head>

<body class="fix-header fix-sidebar card-no-border mini-sidebar">

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <div id="main-wrapper">
        @auth

        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('home') }}">
                        <!-- Logo icon -->
                        <b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('images/logo_utn.png') }}" alt="N" class="p-2" style="width: 55px; height: 60px;">
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span>
                            <!-- Logo text -->
                            <img src="{{ asset('images/logo.png') }}" alt="Inicio" class="p-2" style="width: 190; height: 60px;"/>
                        </span>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark"><i class="mdi mdi-menu ti-close"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark"><i class="ti-menu"></i></a> </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('images/profile.png') }}" alt="Usuario" class="profile-pic">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img">
                                                <img src="{{ asset('images/profile.png') }}" alt="user">
                                            </div>
                                            <div class="u-text">
                                                @if(Auth::user())
                                                <h4>{{ Auth::user()->role->name }}</h4>
                                                <p class="text-muted">{{ Auth::user()->email }}</p>
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-power-off"></i>
                                            Cerrar sesión
                                        </a>
                                    </li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" style="overflow: visible hidden; width: auto; height: 100%;">
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">FACULTAD</li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('/home') }}" aria-expanded="false"><i class="bi bi-house"></i><span class="hide-menu">Inicio</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('/application/index') }}" aria-expanded="false"><i class="bi bi-file-text"></i><span class="hide-menu">Solicitudes</span></a>
                        </li>
                        
                        {{-- ADMIN --}}
                        @if (auth()->user()->rol_id == '1')
                            <li><a class="has-arrow waves-effect waves-dark" aria-expanded="false"><i class="bi bi-person"></i><span class="hide-menu">Personas</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="{{ url('/student/index') }}">Alumnos</a></li>
                                    <li><a href="{{ url('/teacher/index') }}">Docentes</a></li>
                                    <li><a href="{{ url('/responsible/index') }}">Responsables</a></li>
                                </ul>
                            </li>

                        {{-- ESTUDIANTE --}}
                        @elseif(auth()->user()->rol_id == '2')

                        {{-- PROFESOR --}}
                        @elseif(auth()->user()->rol_id == '3')

                        {{-- RESPONSABLE --}}
                        @elseif(auth()->user()->rol_id == '4')
                        
                        @endif
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
        </aside>
        @endauth

        <main class="@auth page-wrapper @endauth">
            @yield('content')
        </main>

        @auth
            <footer class="footer">
                © {{ $today->format('Y') }} - SYSACAD
            </footer>
        @endauth
    </div>
</body>

</html>
