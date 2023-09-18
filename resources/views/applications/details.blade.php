@php
    use Carbon\Carbon;
    $today = Carbon::now(new \DateTimeZone('America/Argentina/Buenos_Aires'));
    $application_end_date = Carbon::parse($application->finish_date);
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

        <!-- Modal -->
        <div id="modalObservation" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <form role="form" class="needs-validation" method="POST" action="{{ url('/application/editObservation') }}" id="form-observation" autocomplete="off" novalidate>
                    @csrf
                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Editar observaciones</h4>
                            <button type="button" class="close" id="btnCloseModal" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-column">
                                        <div class="col-12 mb-3">
                                            <textarea class="form-control" name="observation" style="height: 300px" required>{{ $application->observation }}</textarea>
                                            <div class="invalid-feedback">
                                                Por favor, ingrese una observación
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                            <button id="btnSendObservation" type="button" class="btn btn-success waves-effect waves-light">Editar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal -->

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
                                            <td>
                                                <div class="d-flex flex-row justify-content-start align-items-center">
                                                    {{ $application->Teacher->lastname }}, {{ $application->Teacher->name }}
                                                    @if (auth()->user()->rol_id == 4 && $application->is_finished === false)
                                                        <form id="form-deleteTeacher" action="/application/deleteTeacher" method="post">
                                                            @csrf
                                                            <input type="hidden" name="application_id" value="{{ $application->id }}">
                                                            <button id="btnDeleteTeacher" class="btn btn-sm waves-effect waves-light" type="button" data-name="{{ $application->Teacher->lastname }}, {{ $application->Teacher->name }}"><i class="bi bi-trash3" style="color: red;"></i></button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
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
                                        <td class="col-4">
                                            <b class="font-weight-bold">Observaciones:</b>
                                            @if (auth()->user()->rol_id == 3)
                                                <button class="btn btn-sm waves-effect waves-light" type="button" data-toggle="modal" data-target="#modalObservation"><i class="bi bi-pencil-square"></i></button>
                                            @endif
                                        </td>
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
                            <div class="d-flex flex-row justify-content-between">
                                <form action="/application/downloadWorkPlan/{{ $application->id }}" method="GET">
                                    <button class="btn btn-secondary waves-effect waves-light" type="submit"><span class="btn-label"><i class="bi bi-file-earmark-arrow-down"></i></span>Plan de trabajo</button>
                                </form>

                                @if ($application->FinalReport != null)
                                    <form action="/application/downloadFinalReport/{{ $application->id }}" method="GET">
                                        <button class="btn btn-secondary waves-effect waves-light" type="submit"><span class="btn-label"><i class="bi bi-file-earmark-arrow-down"></i></span>Reporte final</button>
                                    </form>
                                @endif

                                @if ($application->responsible_id === null && auth()->user()->rol_id == 4 && $application->is_finished === false)
                                    <form id="form-takeApplication" action="/application/takeApplication/{{ $application->id }}" method="post">
                                        @csrf
                                        <button id="btnResponsable" class="btn btn-info waves-effect waves-light" type="button">Tomar solicitud</button>
                                    </form>
                                @endif

                            </div>
                            @if (auth()->user()->rol_id == 3 && $application->is_finished === true && $application->is_approved === false)
                                <hr>
                                <div class="d-flex justify-content-end">
                                    <form id="form-approve" action="/application/approve/{{ $application->id }}" method="post">
                                        @csrf
                                        <button id="btnFinish" class="btn btn-success waves-effect waves-light" type="button">Aprobar solicitud</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->rol_id == 2)
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title" style="@if ($today >= $application_end_date) text-decoration: line-through; @endif">Subir seguimiento semanal</h2>
                                    <form id="form-uploadWT" action="/application/uploadWeeklyTracking" method="post">
                                        @csrf
                                        <input name="file" type="file" class="dropify" accept=".pdf" data-max-file-size="2M" @if ($today >= $application_end_date) disabled @endif />
                                        <input type="hidden" name="application_id" value="{{ $application->id }}">
                                        <div class="d-flex justify-content-end mt-2">
                                            <button id="btn-uploadWT" onclick="uploadWT()" class="btn btn-secondary waves-effect waves-light" type="button" style="display: none;"><span class="btn-label"><i class="bi bi-upload"></i></span>Subir</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title" style="@if ($today < $application_end_date || $application->FinalReport != null) text-decoration: line-through; @endif">Subir reporte final</h2>
                                    <form id="form-uploadFR" action="/application/uploadFinalReport" method="post">
                                        @csrf
                                        <input name="file" type="file" class="dropify" accept=".pdf" data-max-file-size="2M" @if ($today < $application_end_date || $application->FinalReport != null) disabled @endif />
                                        <input type="hidden" name="application_id" value="{{ $application->id }}">
                                        <div class="d-flex justify-content-end mt-2">
                                            <button id="btn-uploadFR" onclick="uploadFR()" class="btn btn-secondary waves-effect waves-light btn-upload" type="button" style="display: none;"><span class="btn-label"><i class="bi bi-upload"></i></span>Subir</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif (auth()->user()->rol_id == 4 && $application->teacher_id === null)
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Asignar profesor</h2>
                            <form id="form-teacher" action="/application/assignTeacher" method="POST">
                                @csrf
                                <input type="hidden" name="application_id" value="{{ $application->id }}">
                                <hr class="m-0">
                                <div class="table-responsive">
                                    <table id="DataTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Teléfono</th>
                                                <th>Email</th>
                                                <th>Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">
                                            @foreach ($professors as $professor)
                                                <tr data-id="{{ $professor->Person->id }}" >
                                                    <td>{{ $professor->Person->lastname }}, {{ $professor->Person->name }}</td>
                                                    <td>{{ $professor->Person->phone }}</td>
                                                    <td>{{ $professor->email }}</td>
                                                    <td class="text-center">
                                                        <input type="radio" name="teacher_id" value="{{ $professor->Person->id }}" id="professor_{{ $professor->Person->id }}" class="check" data-radio="iradio_square-purple" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <button id="btnTeacher" class="btn btn-info waves-effect waves-light" type="button" style="display: none">Asignar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Seguimientos semanales</h2>
                        <hr>
                        <!-- TIMELINE DE SEGUIMIENTOS -->
                        <ul class="timeline">
                            <?php $contador = 0;?>
                            @foreach ($application->WeeklyTrackings->sortBy('created_at') as $wt)
                                <?php $contador++; ?>
                                <li class="@if($contador % 2 != 0) timeline-inverted @endif">
                                    <div class="timeline-badge" style="background-color: #6c757d"><i class="bi bi-file-text"></i></div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h3 class="timeline-title name-element text-center">Archivo #{{ $contador }}</h3>
                                        </div>
                                        <hr>
                                        <div class="timeline-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p><b class="font-weight-bold">Fecha de subida:</b> {{ $wt->created_at->format('d/m/Y') }}</p>
                                                    @if ($wt->is_accepted == true)
                                                        <td><span class="label label-success">Aceptado</span></td>
                                                    @else
                                                        <td><span class="label label-warning">Sin aceptar</span></td>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <hr>
                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <!-- Download -->
                                                <form action="/application/downloadWeeklyTracking/{{ $wt->id }}" method="GET">
                                                    <button class="btn btn-secondary waves-effect waves-light" type="submit"><span class="btn-label"><i class="bi bi-file-earmark-arrow-down"></i></span>Descargar</button>
                                                </form>

                                                <!-- Delete -->
                                                @if ($wt->is_accepted == false && auth()->user()->rol_id == 2)
                                                    <form id="form-deleteWT_{{ $wt->id }}" action="{{ url('/application/deleteWeeklyTracking') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $wt->id }}">
                                                        <button onclick="deleteWT({{ $wt->id }})" type="button" class="btn btn-sm btn-danger btn-rounded px-3">Eliminar</button>
                                                    </form>
                                                @endif
                                            </div>

                                            @if ($wt->is_accepted == false && auth()->user()->rol_id == 3)
                                            <hr>
                                            <div class="d-flex flex-row justify-content-end">
                                                <form id="form-acceptWT_{{ $wt->id }}" action="{{ url('/application/acceptWeeklyTracking') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $wt->id }}">
                                                    <button onclick="acceptWT({{ $wt->id }})" type="button" class="btn btn-sm btn-info btn-rounded px-3">Aceptar</button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dataTables_scrollHeadInner {
            width: 100% !important;
        }
        .dataTables_scrollHeadInner table {
            width: 100% !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#DataTable").DataTable({
                "language": {
                    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ profesores",
                    "sInfoEmpty": "Mostrando 0 a 0 de 0 profesores",
                    "sInfoFiltered": "(filtrado de _MAX_ profesores en total)",
                    "emptyTable": 'No hay profesores que coincidan con la búsqueda',
                    "sLengthMenu": "Mostrar _MENU_ profesores",
                    "sSearch": "Buscar:",
                },
                "scrollY": '30vh',
                "scrollCollapse": true,
                "paging": false,
                "info": false,
                "order": [[ 0, "asc" ]],
            });

            let drEvent = $('.dropify').dropify({
                messages: {
                    'default': 'Arrastre el archivo aquí o haga clic',
                    'replace': 'Arrastre el archivo aquí o haga clic para reemplazar',
                    'remove':  'Eliminar',
                    'error':   'Ooops, ocurrió un error.'
                },
                error: {
                    'fileSize': 'El tamaño del archivo es demasiado grande. Máximo 2MB.',
                }
            });

            drEvent.on('dropify.afterClear', function(event, element) {
                $('#btn-uploadWT').hide();
                $('#btn-uploadFR').hide();
            });
            drEvent.on('dropify.errors', function(event, element){
                $('#btn-uploadWT').hide();
                $('#btn-uploadFR').hide();
            });
        });

        const SwalError = (title, text = "") => {
            Swal.fire({
                icon: 'error',
                title: title,
                text: text,
                confirmButtonColor: '#1e88e5',
            });
        };
    </script>

    <script>
        $('#form-uploadFR input[type="file"]').change(function () {
            if ($(this).get(0).files.length > 0) {
                $('#btn-uploadFR').show();
            } else {
                $('#btn-uploadFR').hide();
            }
        });
        $('#form-uploadWT input[type="file"]').change(function () {
            if ($(this).get(0).files.length > 0) {
                $('#btn-uploadWT').show();
            } else {
                $('#btn-uploadWT').hide();
            }
        });

        $('input').on('ifClicked', function (ev) { 
            $("#btnTeacher").show();
        });

        $("#btnFinish").on("click", function () {
            Swal.fire({
                title: 'Esta acción no se puede revertir',
                text: '¿Seguro deseas aprobar esta solicitud?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info waves-effect waves-light px-3 py-2',
                    cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $("#form-approve");
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: $(form).serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                confirmButtonColor: '#1e88e5',
                                allowOutsideClick: false,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(errorThrown) {
                            SwalError(errorThrown.responseJSON.message);
                        }
                    });
                }
            });
        });

        $("#btnDeleteTeacher").on("click", function() {
            let professor_name = $(this).data('name');
            Swal.fire({
                text: `¿Seguro deseas eliminar a ${professor_name} de esta PPS?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger waves-effect waves-light px-3 py-2',
                    cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $("#form-deleteTeacher");
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: $(form).serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                confirmButtonColor: '#1e88e5',
                                allowOutsideClick: false,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(errorThrown) {
                            SwalError(errorThrown.responseJSON.message);
                        }
                    });
                }
            });
        });

        $("#btnTeacher").on("click", function() {
            let professor_name = $(`#form-teacher input[name='teacher_id']:checked`).parent().parent().parent().find('td:nth-child(1)').text();
            Swal.fire({
                text: `¿Seguro deseas asignar a ${professor_name} a esta PPS?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info waves-effect waves-light px-3 py-2',
                    cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $("#form-teacher");
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: $(form).serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                confirmButtonColor: '#1e88e5',
                                allowOutsideClick: false,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(errorThrown) {
                            SwalError(errorThrown.responseJSON.message);
                        }
                    });
                }
            });
        });

        $("#btnSendObservation").on("click", function() {
            let form = $("#form-observation");
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: $(form).serialize(),
                success: function(response) {
                    $("#btnCloseModal").click();
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        confirmButtonColor: '#1e88e5',
                        allowOutsideClick: false,
                    });
                },
                error: function(errorThrown) {
                    SwalError(errorThrown.responseJSON.message);
                }
            });
        });

        $("#btnResponsable").on("click", function() {
            Swal.fire({
                title: "Esta acción no se puede revertir",
                text: '¿Seguro deseas tomar esta solicitud?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info waves-effect waves-light px-3 py-2',
                    cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $("#form-takeApplication");
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: $(form).serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                confirmButtonColor: '#1e88e5',
                                allowOutsideClick: false,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(errorThrown) {
                            SwalError(errorThrown.responseJSON.message);
                        }
                    });
                }
            });
        });

        function uploadWT() {
            let form = $("#form-uploadWT");
            let formData = new FormData();
            let file = $("#form-uploadWT input[name='file']")[0].files[0];
            formData.append('application_id', $("#form-uploadWT input[name='application_id']").val());
            formData.append('_token', $("#form-uploadWT input[name='_token']").val());
            formData.append('file', file);

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        confirmButtonColor: '#1e88e5',
                        allowOutsideClick: false,
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: errorThrown.responseJSON.title,
                        text: errorThrown.responseJSON.message,
                        confirmButtonColor: '#1e88e5',
                    });
                }
            });
        }

        function deleteWT(id) {
            let form = $(`#form-deleteWT_${id}`);
            Swal.fire({
                title: "Esta acción no se puede revertir",
                text: '¿Seguro deseas eliminar este archivo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger waves-effect waves-light px-3 py-2',
                    cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: $(form).serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                confirmButtonColor: '#1e88e5',
                                allowOutsideClick: false,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(errorThrown) {
                            SwalError(errorThrown.responseJSON.message);
                        }
                    });
                }
            });
        }

        function acceptWT(id) {
            let form = $(`#form-acceptWT_${id}`);
            Swal.fire({
                title: "Esta acción no se puede revertir",
                text: '¿Seguro deseas aceptar este seguimiento?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info waves-effect waves-light px-3 py-2',
                    cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: $(form).serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                confirmButtonColor: '#1e88e5',
                                allowOutsideClick: false,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(errorThrown) {
                            SwalError(errorThrown.responseJSON.message);
                        }
                    });
                }
            });
        }

        function uploadFR() {
            let form = $("#form-uploadFR");
            let formData = new FormData();
            let file = $("#form-uploadFR input[name='file']")[0].files[0];
            formData.append('application_id', $("#form-uploadFR input[name='application_id']").val());
            formData.append('_token', $("#form-uploadFR input[name='_token']").val());
            formData.append('file', file);

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        confirmButtonColor: '#1e88e5',
                        allowOutsideClick: false,
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: errorThrown.responseJSON.title,
                        text: errorThrown.responseJSON.message,
                        confirmButtonColor: '#1e88e5',
                    });
                }
            });
        }
    </script>

    <!-- jQuery file upload -->
    <script src="{{ asset('plugins/dropify/dist/js/dropify.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection