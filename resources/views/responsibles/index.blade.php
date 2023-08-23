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
                <h3 class="text-themecolor m-b-0 m-t-0">Responsables</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Responsables</li>
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
                        <h2 class="card-title">Listado de responsables</h4>
                        <div class="table-responsive m-t-10">
                            <table id="DataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Legajo</th>
                                        <th>Email</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                    @foreach ($responsibles as $responsible)
                                        <tr>
                                            <td>{{ $responsible->Person->lastname }}, {{ $responsible->Person->name }}</td>
                                            <td>{{ $responsible->Person->address }}</td>
                                            <td>{{ $responsible->Person->phone }}</td>
                                            <td>{{ $responsible->Person->file_number }}</td>
                                            <td>{{ $responsible->email }}</td>
                                            <td class="text-center">
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
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ responsables",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 responsables",
                "sInfoFiltered": "(filtrado de _MAX_ responsables en total)",
                "emptyTable": 'No hay responsables que coincidan con la búsqueda',
                "sLengthMenu": "Mostrar _MENU_ responsables",
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
