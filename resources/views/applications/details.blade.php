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
                    <li class="breadcrumb-item"><a href="{{ url('/application/index') }}">Solicitudes</a></li>
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
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-body">
                            <h2 class="box-title">Detalles de la solicitud #{{ $application->id }}</h2>
                            <p class="box-subtitle">{{ $application->created_at->format('d/m/Y') }}</p>
                            <hr class="m-t-0 m-b-20">
                            {{-- Table con 4 columnas que contenga los datos de la application --}}
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Estudiante:</b></td>
                                        <td>{{ $application->Student->lastname }}, {{ $application->Student->name }} - Legajo: {{ $application->Student->file_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Responsable:</b></td>
                                        @if ($application->responsible_id != null)
                                            <td>{{ $application->Responsible->lastname }}, {{ $application->Responsible->name }}</td>
                                        @else
                                            <td>Sin asignar</td>                                            
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Profesor a cargo:</b></td>
                                        @if ($application->teacher_id != null)
                                            <td>{{ $application->Teacher->lastname }}, {{ $application->Teacher->name }}</td>
                                        @else
                                            <td>Sin asignar</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Fecha de inicio/fin:</b></td>
                                        <td>{{ \Carbon\Carbon::parse($application->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($application->finish_date)->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Descripción:</b></td>
                                        <td>{{ $application->description }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Observaciones:</b></td>
                                        <td>{{ $application->observation != null ? $application->observation : "-" }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Estado:</b></td>
                                        @if ($application->is_approved == true)
                                            @if ($application->is_finished == true)
                                                <td><span class="label label-success">Finalizada</span> - <span class="label label-success">Aprobada</span></td>
                                            @else
                                                <td><span class="label label-warning">Sin finalizar</span> - <span class="label label-success">Aprobada</span></td>
                                            @endif
                                        @else
                                            @if ($application->is_finished == true)
                                                <td><span class="label label-success">Finalizada</span> - <span class="label label-danger">Pendiente de aprobación</span></td>
                                            @else
                                                <td><span class="label label-warning">Sin finalizar</span> - <span class="label label-danger">Pendiente de aprobación</span></td>
                                            @endif
                                        @endif
                                        <td>{{ $application->status }}</td>
                                    </tr>
                                </tbody>    
                            </table>
                            <hr class="m-t-0 m-b-20">
                            <form action="/application/downloadWorkPlan/{{ $application->id }}" method="GET">
                                <button class="btn btn-secondary waves-effect waves-light" type="submit"><span class="btn-label"><i class="bi bi-arrow-down-square"></i></span>Plan de trabajo</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">Subir seguimientos semanales</h2>
                                <input type="file" class="dropify" />
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
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
            let drEvent = $('.dropify').dropify({
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