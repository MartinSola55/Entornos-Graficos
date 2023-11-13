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
        <main>
            <div class="login-register" style="background-image: url('/images/background-login-image.jpeg');"">
                <div class="login-box card" style="background-color: #ffffff54">
                    <div class="card-body sombra p-4">
                        <form class="form-horizontal form-material" id="loginform" method="POST" action="{{ route('login') }}">
                            @csrf
                            <h3 class="box-title m-b-20 text-center">Iniciar sesión</h3>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" style="color: 0000009c">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Contraseña" style="color: 0000009c">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex no-block align-items-center">
                                    <div class="checkbox checkbox-primary p-t-0">
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} >
                                        <label for="remember" style="color: 0000009c"> Recordarme </label>
                                    </div> 
                                </div>
                                {{-- <div class="d-flex justify-content-center mt-4">
                                    <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fa fa-lock m-r-5"></i> ¿Olvidaste tu contraseña?</a> 
                                </div> --}}
                            </div>
                            <div class="form-group text-center m-t-20">
                                <div class="col-xs-12">
                                    <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" style="background-color: #184587;">Acceder</button>
                                </div>
                            </div>
                        </form>
                        @if (Route::has('password.request'))
                            <form method="POST" class="form-horizontal form-material" id="recoverform" action="#">
                                <div class="form-group ">
                                    <div class="col-xs-12">
                                        <div class="d-flex flex-row justify-content-between">
                                            <h3>Recuperar contraseña</h3>
                                            <div style="cursor: pointer" onclick="closeRecoverPassword()"><i class="bi bi-x-lg"></i></div>
                                        </div>    
                                        <p class="text-muted">Ingresa tu email y te enviaremos las instrucciones</p>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="email" name="email" required placeholder="Email"> </div>
                                </div>
                                <div class="form-group text-center m-t-20">
                                    <div class="col-xs-12">
                                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" style="background-color: #184587;">Restablecer</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function closeRecoverPassword() {
            $("#loginform").css("display", "block");
            $("#recoverform").css("display", "none");
        }
        $(".invalid-feedback").css("display", "block");
    </script>
</body>

</html>