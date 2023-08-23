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
                <h3 class="text-themecolor m-b-0 m-t-0">PPS</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">PPS</li>
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
                        <h2 class="card-title">Listado de prácticas</h4>
                        <div class="table-responsive m-t-10">
                            <table id="DataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-10">Descripción</th>
                                        <th class="col-2">Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                    @foreach ($pps as $practica)
                                        <tr>
                                            <td>{{ $practica->description }}</td>
                                            <td class="d-flex justify-content-center">
                                                <button class="btn btn-info" data-id="{{ $practica->id }}" name="btnSelect">Nueva sol.</button>
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
        <form id="form-create" method="POST" action="/application/create">
            @csrf
            <input type="hidden" name="pps_id" value="">
        </form>
    </div>

    <script>
        $('#DataTable').DataTable({
            "language": {
                // "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" // La url reemplaza todo al español
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ prácticas",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 prácticas",
                "sInfoFiltered": "(filtrado de _MAX_ prácticas en total)",
                "emptyTable": 'No hay prácticas que coincidan con la búsqueda',
                "sLengthMenu": "Mostrar _MENU_ prácticas",
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

    <script>
        $("button[name='btnSelect']").on("click", function () {
            let row = $(this).closest("tr");
            let description = row.find("td:eq(0)").text();
            let pps_id = $(this).data("id");
            Swal.fire({
                title: `¿Desea seleccionar la práctica "${description}"?`,
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success waves-effect waves-light px-3 py-2',
                    cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $("#form-create");
                    form.find("input[name='pps_id']").val(pps_id);
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: $(form).serialize(),
                        success: function (response) {
                            Swal.fire({
                                title: response.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#1e88e5',
                                confirmButtonText: 'OK',
                                allowOutsideClick: false,
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
            })
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
