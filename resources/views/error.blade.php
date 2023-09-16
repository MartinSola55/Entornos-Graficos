@php
    use Carbon\Carbon;
    $today = Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">
    <title>Error</title>
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- You can change the theme colors from here -->
    <link rel="stylesheet" href="{{ asset('css/colors/default-dark.css') }}">
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="text-info">{{ $error->code }}</h1>
                <h3 class="text-uppercase">ERROR</h3>
                <p class="text-muted m-t-30 m-b-30">{{ $error->message }}</p>
                @if ($error->code < 500)
                    <a href="{{ url('home') }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Volver al inicio</a>
                @endif
            </div>
            <footer class="footer text-center">© {{ $today->format('Y') }} - SYSACAD</footer>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('plugins/popper/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('js/waves.js') }}"></script>
</body>

</html>