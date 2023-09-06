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
                    <li class="breadcrumb-item active">Nueva</li>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body wizard-content">
                        <h4 class="card-title">Nueva solicitud</h4>
                        <h6 class="card-subtitle mb-0">{{ $today->format('d/m/Y') }}</h6>
                        <form action="/application/create" class="tab-wizard wizard-circle" id="form_data" method="POST">
                            @csrf
                            <input name="student_id" value="{{ $student->Person->id }}" type="hidden" />
                            <input name="finish_date" value="" type="hidden" />
                            <!-- Step 1 -->
                            <h6>Alumno</h6>
                            <section>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-body">
                                            <h3 class="box-title">Tus datos</h3>
                                            <hr class="m-t-0 m-b-20">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-md-right col-5">Nombre:</label>
                                                        <div class="col-7 pr-0">
                                                            <p class="form-control-static">{{ $student->Person->name }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-md-right col-5">Apellido:</label>
                                                        <div class="col-7 pr-0">
                                                            <p class="form-control-static">{{ $student->Person->lastname }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-md-right col-5">Teléfono:</label>
                                                        <div class="col-7 pr-0">
                                                            <p class="form-control-static">{{ $student->Person->phone }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-md-right col-5">Dirección:</label>
                                                        <div class="col-7 pr-0">
                                                            <p class="form-control-static">{{ $student->Person->address }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-md-right col-5">Legajo:</label>
                                                        <div class="col-7 pr-0">
                                                            <p class="form-control-static">{{ $student->Person->file_number }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-md-right col-5">Email:</label>
                                                        <div class="col-7 pr-0">
                                                            <p class="form-control-static">{{ $student->email }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 2 -->
                            <h6>Datos</h6>
                            <section>
                                <h3 class="box-title">Datos de la PPS</h3>
                                <hr class="m-t-0 m-b-20">
                                <div class="row col-12 m-0 p-0">
                                    <!-- Date -->
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="DatePicker" class="mb-0">Fecha de finalización</label>
                                        <input name="DatePicker" id="DatePicker" class="form-control" type="text" placeholder="dd/mm/aaaa" />
                                    </div>

                                    <!-- Description -->
                                    <div class="col-12 col-md-8 mb-3">
                                        <label for="description" class="mb-0">Descripción</label>
                                        <textarea id="description" name="description" class="form-control" style="height: 150px"></textarea>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 3 -->
                            <h6>Profesor</h6>
                            <section>
                                <h3 class="box-title">Profesor</h3>
                                <hr class="m-t-0 m-b-20">
                                <div class="row col-12 m-0 p-0">
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
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #DataTable_wrapper > div:nth-child(2) > div > div > div.dataTables_scrollHead > div,
        #DataTable_wrapper > div:nth-child(2) > div > div > div.dataTables_scrollHead > div > table {
            width: 100% !important;
        }
    </style>


    <script>
        $(document).ready(function () {
            $('#DataTable').DataTable({
                scrollY: '30vh',
                scrollCollapse: true,
                paging: false,
                "language": {
                    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ profesores",
                    "sInfoEmpty": "Mostrando 0 a 0 de 0 profesores",
                    "sInfoFiltered": "(filtrado de _MAX_ profesores en total)",
                    "emptyTable": 'No hay profesores que coincidan con la búsqueda',
                    "sLengthMenu": "Mostrar _MENU_ profesores",
                    "sSearch": "Buscar:",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior",
                    },
                },
            });
        });

        $(".tab-wizard").steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                cancel: "Cancelar",
                next: "Siguiente",
                previous: "Anterior",
                finish: "Enviar",
            },
            onFinished: function (event, currentIndex) {
                if (validateData()) {
                    sendForm();
                }
            }
        });

        $(document).ready(function () {
            // Establecer el idioma de Moment.js en español
            moment.locale('es');

            // Configurar bootstrapMaterialDatePicker con el formato y opciones deseadas
            $('#DatePicker').bootstrapMaterialDatePicker({
                minDate: moment(),
                time: false,
                format: 'DD/MM/YYYY',
                cancelText: 'Cancelar',
                weekStart: 1,
                lang: 'es',
            });
        });
    </script>

    <script>
        const fireAlert = (text) => {
            Swal.fire({
                icon: 'warning',
                title: 'ALERTA',
                text: text,
                showCancelButton: false,
                confirmButtonColor: '#1e88e5',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            });
            return false;
        };

        function validatePPS() {
            let date = $("input[name='DatePicker']").val();
            let description = $("textarea[name='description']").val();

            if (date == "") return fireAlert("Debes ingresar una fecha de finalización");
            if (description == "") return fireAlert("Debes ingresar una descripción");

            return true;
        }

        function validateTeacher() {
            let check = $("#DataTable tbody tr td input[type='radio']:checked");
            if (check.length <= 0) return fireAlert("Debes seleccionar un profesor");
            return true;
        }

        function validateData() {
            if (!validatePPS()) return false;
            if (!validateTeacher()) return false;
            return true;
        }

        function formatDate(dateString) {
            // La fecha llega como dd/mm/yyyy y se convierte a yyyy-mm-dd
            let dateParts = dateString.split("/");
            let formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];
            return formattedDate;
        }

        function sendForm() {
            let form = $("#form_data");
            $('#finish_date').val("");
            $('#finish_date').val(formatDate($('#DatePicker').val()));

            // Enviar solicitud AJAX
            $.ajax({
                url: $(form).attr('action'), // Utiliza la ruta del formulario
                method: $(form).attr('method'), // Utiliza el método del formulario
                data: $(form).serialize(), // Utiliza los datos del formulario
                success: function (response) {
                    Swal.fire({
                        title: response.message,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#1e88e5',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                        .then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = window.location.origin;
                            }
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection