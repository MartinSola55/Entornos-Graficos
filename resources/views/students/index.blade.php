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
                <h3 class="text-themecolor m-b-0 m-t-0">Alumnos</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Alumnos</li>
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
        <div id="modalCreate" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div id="formContainer" class="modal-dialog">
                <form role="form" class="needs-validation" method="POST" action="{{ url('/student/create') }}" id="form-create" autocomplete="off" novalidate>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modalTitle" class="modal-title"></h4>
                            <button type="button" class="close" id="btnCloseModalCreate" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-column">
                                        @csrf
                                        <input type="hidden" name="id" value="">

                                        <div class="col-12 mb-3">
                                            <label for="clientName" class="mb-0">Nombre</label>
                                            <input type="text" class="form-control" id="clientName" name="name" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingrese un nombre
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="clientLastName" class="mb-0">Apellido</label>
                                            <input type="text" class="form-control" id="clientLastName" name="lastname" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingrese un apellido
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="clientAdress" class="mb-0">Dirección</label>
                                            <input type="text" class="form-control" id="clientAdress" name="address" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingrese una dirección
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="clientPhone" class="mb-0">Teléfono</label>
                                            <input type="tel" class="form-control" id="clientPhone" name="phone">
                                            <div class="invalid-feedback">
                                                Por favor, ingrese un teléfono
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="clientFileNumber" class="mb-0">Legajo</label>
                                            <input type="tel" class="form-control" id="clientFileNumber" name="file_number">
                                            <div class="invalid-feedback">
                                                Por favor, ingrese un legajo
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="clientEmail" class="mb-0">Email</label>
                                            <input type="email" class="form-control" id="clientEmail" name="email">
                                            <div class="invalid-feedback">
                                                Por favor, ingrese un email
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3" id="passwordCheckBox">
                                            <div>
                                                <input type="checkbox" id="clientInvoice" name="invoice" value="1"/>
                                                <label for="clientInvoice">¿Cambiar contraseña?</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3" id="passwordContainer">
                                            <label for="clientPassword" class="mb-0">Contraseña</label>
                                            <input type="password" min="0" class="form-control" id="clientPassword" name="password">
                                            <div class="invalid-feedback">
                                                Por favor, ingrese una Contraseña
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                            <button id="btnSendModal" type="button" class="btn btn-success waves-effect waves-light">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-between">
                            <h2 class="card-title">Listado de alumnos</h2>
                            <button id="btnAdd" type="button" class="btn btn-info btn-rounded waves-effect waves-light m-t-10 float-right" data-toggle="modal" data-target="#modalCreate">Agregar nuevo alumno</button>
                        </div>
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
                                    @foreach ($students as $student)
                                        <tr data-id="{{ $student->Person->id }}">
                                            <td>{{ $student->Person->lastname }}, {{ $student->Person->name }}</td>
                                            <td>{{ $student->Person->address }}</td>
                                            <td>{{ $student->Person->phone }}</td>
                                            <td>{{ $student->Person->file_number }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td class="d-flex flex-row justify-content-center">
                                                <button type='button' class='btn btn-outline-info btn-rounded btn-sm mr-2' onclick='edit({{ json_encode($student) }})' data-toggle="modal" data-target="#modalCreate"><i class="bi bi-pencil"></i></button>
                                                <button type='button' class='btn btn-danger btn-rounded btn-sm ml-2' onclick='deleteObj({{ $student->person->id }})'><i class='bi bi-trash3'></i></button>
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
        <form id="form-delete" action="{{ url('/student/delete') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="id" value="">
        </form>
    </div>

    <script>
        function fillTable(item) {
            let content = `
                <tr data-id='${item.person.id}'>
                    <td>${item.person.lastname}, ${item.person.name}</td>
                    <td>${item.person.address}</td>
                    <td>${item.person.phone}</td>
                    <td>${item.person.file_number}</td>
                    <td>${item.email}</td>
                    <td class='d-flex flex-row justify-content-center'>
                        <button type='button' class='btn btn-outline-info btn-rounded btn-sm mr-2' onclick='edit(${JSON.stringify(item)})' data-toggle="modal" data-target="#modalCreate"><i class="bi bi-pencil"></i></button>
                        <button type='button' class='btn btn-danger btn-rounded btn-sm ml-2' onclick='deleteObj(${item.person.id})'><i class='bi bi-trash3'></i></button>
                    </td>
                </tr>`;
            $('#DataTable').DataTable().row.add($(content)).draw();
        }

        function removeFromTable(id) {
            $('#DataTable').DataTable().row(`[data-id="${id}"]`).remove().draw();
        }

        function deleteObj(id) {
            Swal.fire({
                title: "¿Seguro deseas eliminar este alumno?",
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger waves-effect waves-light px-3 py-2',
                    cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
                }
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $("#form-delete input[name='id']").val(id);
                    sendForm("delete");
                }
            });
        }

        function sendForm(action) {
            let form = document.getElementById(`form-${action}`);

            // Enviar solicitud AJAX
            $.ajax({
                url: $(form).attr('action'), // Utiliza la ruta del formulario
                method: $(form).attr('method'), // Utiliza el método del formulario
                data: $(form).serialize(), // Utiliza los datos del formulario
                success: function (response) {
                    $("#btnCloseModalCreate").click();
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        confirmButtonColor: '#1e88e5',
                    });
                    if (action === 'create') {
                        fillTable(response.data);
                    } else if (action === 'edit'){
                        removeFromTable(response.data.person.id);
                        fillTable(response.data);
                    } else {
                        removeFromTable(response.data);
                    }
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

    <script>
        $("#passwordCheckBox").on("click", function() {
            if ($("#passwordCheckBox input").is(":checked")) {
                $("#passwordContainer").css("display", "block");
            } else {
                $("#passwordContainer").css("display", "none");
            }
        });

        $("#btnSendModal").on("click", function (e) {
            if ($("#formContainer form").attr('id') === 'form-create') {
                sendForm("create");
            } else if ($("#formContainer form").attr('id') === 'form-edit') {
                sendForm("edit");
            }
        });
        $("#btnAdd").on("click", function () {
            $("#modalTitle").text("Agregar alumno");
            $("#formContainer form").attr("action", "/student/create");
            $("#formContainer form").attr("id", "form-create");
            $("#formContainer form input:not([type='hidden']").val("");
            $("#formContainer form input[name='id']").prop("disabled", true);
            $("#btnSendModal").text("Agregar");
            $("#passwordCheckBox").css("display", "none");
            $("#passwordContainer").css("display", "block");
        });

        function edit(entity) {
            $("#formContainer form input:not([type='hidden']").val("");
            $("#formContainer form input[name='id']").val(entity.person.id);
            $("#formContainer form input[name='id']").prop("disabled", false);

            $("#modalTitle").text("Editar alumno");
            $("#formContainer form").attr("action", "/student/edit");
            $("#formContainer form").attr("id", "form-edit");
            $("#btnSendModal").text("Confirmar");

            $("#passwordCheckBox").css("display", "block");
            $("#passwordContainer").css("display", "none");

            $("input[name='name']").val(entity.person.name);
            $("input[name='lastname']").val(entity.person.lastname);
            $("input[name='address']").val(entity.person.address);
            $("input[name='phone']").val(entity.person.phone);
            $("input[name='file_number']").val(entity.person.file_number);
            $("input[name='email']").val(entity.email);
        }
    </script>
    <script>
        $('#DataTable').DataTable({
            "language": {
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ alumnos",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 alumnos",
                "sInfoFiltered": "(filtrado de _MAX_ alumnos en total)",
                "emptyTable": 'No hay alumnos que coincidan con la búsqueda',
                "sLengthMenu": "Mostrar _MENU_ alumnos",
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
