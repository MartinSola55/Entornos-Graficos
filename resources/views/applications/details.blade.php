@php
    use Carbon\Carbon;
    $today = Carbon::now(new \DateTimeZone('America/Argentina/Buenos_Aires'));
@endphp
@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/icheck/skins/all.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/wizard/steps.css') }}" rel="stylesheet" />
    <!-- Switchery -->
    <link href="{{ asset('plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
    <!-- Datepicker -->
    <link href="{{ asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    
    <link href="{{ asset('plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet" >

    <!-- Switchery -->
    <script src="{{ asset('plugins/switchery/dist/switchery.min.js') }}"></script>
    <!-- Datepicker -->
    <script src="{{ asset('plugins/moment/moment-with-locales.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <!-- Editable -->
    <script src="{{ asset('plugins/jquery-datatables-editable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>
    <!-- icheck -->
    <script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('plugins/icheck/icheck.init.js') }}"></script>
    <!-- Steps -->
    <script src="{{ asset('plugins/wizard/jquery.steps.min.js') }}"></script>

    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Solicitudes</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/applications/index') }}">Solicitudes</a></li>
                    <li class="breadcrumb-item active">Detalles</li>
                </ol>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Detalles de la solicitud #{{ $application->id }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">Subir seguimientos semanales</h2>
                                <input type="file" class="dropify" />
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">Subir reporte final</h2>
                                <input type="file" class="dropify" disabled />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var drEvent = $('.dropify').dropify({
                messages: {
                    'default': 'Arrastre el archivo aquí o haga clic',
                    'replace': 'Arrastre el archivo aquí o haga clic para reemplazar',
                    'remove':  'Eliminar',
                    'error':   'Ooops, ocurrió un error.'
                }
            });

            drEvent.on('dropify.errors', function(event, element) {
                console.log('Has Errors');
            });
        });
    </script>

    <!-- jQuery file upload -->
    <script src="{{ asset('plugins/dropify/dist/js/dropify.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection