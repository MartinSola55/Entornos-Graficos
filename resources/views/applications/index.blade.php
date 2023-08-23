@extends('layouts.app')

@section('content')
    <!-- Data table -->
    <link href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- This is data table -->
    <script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>

    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Solicitudes</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Solicitudes</li>
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
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title">Listado de solicitudes</h4>
                        <div class="table-responsive m-t-10">
                            <table id="DataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Estudiante</th>
                                        <th>Responsable</th>
                                        <th>Profesor</th>
                                        <th>PPS</th>
                                        <th>Fecha fin</th>
                                        <th>Observación</th>
                                        <th>Finalizada</th>
                                        <th>Aprobada</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                    @foreach ($applications as $app)
                                        <tr>
                                            <td>{{ $app->Student->lastname }}, {{ $app->Student->name }}</td>
                                            <td>{{ $app->Responsible->lastname }}, {{ $app->Responsible->name }}</td>
                                            <td>{{ $app->Teacher->lastname }}, {{ $app->Teacher->name }}</td>
                                            <td>{{ $app->description }}</td>
                                            <td>{{ $app->finish_date ? $app->finish_date->format('d/m/Y') : "-" }}</td>
                                            <td>{{ $app->observation }}</td>
                                            <td class="text-center">
                                                @if ( $app->is_finished == true)
                                                    <i class="bi bi-check2" style="font-size: 1.5rem"></i>
                                                @else
                                                    <i class="bi bi-x-lg" style="font-size: 1.3rem"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ( $app->is_approved == true)
                                                    <i class="bi bi-check2" style="font-size: 1.5rem"></i>
                                                @else
                                                    <i class="bi bi-x-lg" style="font-size: 1.3rem"></i>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#DataTable').DataTable({
            "language": {
                // "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" // La url reemplaza todo al español
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ solicitudes",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 solicitudes",
                "sInfoFiltered": "(filtrado de _MAX_ solicitudes en total)",
                "emptyTable": 'No hay solicitudes que coincidan con la búsqueda',
                "sLengthMenu": "Mostrar _MENU_ solicitudes",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior",
                },
            },
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
