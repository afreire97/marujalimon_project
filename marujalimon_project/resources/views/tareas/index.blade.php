<x-layout>








    <div class="mode-container m-3"
        style="display: flex; align-items: center; justify-content: space-between; background-color: #008080; padding: 10px; border-radius: 5px; width: 100%;">
        <a href="{{ route('lugares.index') }}" class="btn btn-success">Volver</a>
        <div style="flex-grow: 1; display: flex; justify-content: center;">


        </div>
        <div class="button-container d-flex justify-content-end align-items-center">
            <div class="container d-flex justify-content-end">
                <div class="row">




                    <div class="d-flex justify-content-end">

                        <a href="#modal-dialog-tarea" class="btn  btn-success" id="tareaButton"
                            data-bs-toggle="modal">Añadir
                            tarea</a>

                        <form id="deleteFormLugar" action="{{ route('lugares.destroy', ['lugar' => $lugar]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDeleteLugar()">Eliminar
                                Lugar</button>
                        </form>
                    </div>




                </div>
            </div>
        </div>
    </div>

    <div class="card text-center">
        <div class="card-body d-flex flex-column align-items-center">
            <div id="modeDisplay" class="text-position" style="color: black; font-size: 24px;"> Tareas en:
                {{ $lugar->LUG_nombre }}</div>

            <p><strong>Dirección:</strong> {{ $lugar->LUG_direccion }}</p>

            <a href="{{ route('lugares.showVoluntarios', ['lugar' => $lugar]) }}" class="btn btn-sm btn-primary">
                Información del personal
            </a>
        </div>
    </div>



    {{-- MODAL PARA AÑADIR TAREA --}}
    <div class="modal fade" id="modal-dialog-tarea">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Añadir tarea a {{ $lugar->LUG_nombre }}</h4>
                </div>
                <div class="modal-body">
                    <!-- Formulario de añadir tarea -->
                    <form>
                        @csrf
                        <input type="hidden" name="voluntariosSeleccionados" id="voluntariosSeleccionados"
                            value="">
                        <input type="hidden" name="lugar" id="lugar" value="{{ $lugar->LUG_id }}">

                        <div class="mb-3">
                            <label for="nueva_tarea" class="form-label">Nueva tarea:</label>
                            <input type="text" class="form-control" id="nueva_tarea" name="nueva_tarea" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="btn-añadirTarea"
                        onclick="agregarTarea()">Añadir</button>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL PARA MODIFICAR TAREA --}}
    <div class="modal fade" id="modal-dialog-modificar-tarea">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modificar tarea</h4>
                </div>
                <div class="modal-body">
                    <!-- Formulario de modificar tarea -->
                    <form>
                        @csrf
                        <input type="hidden" name="tarea_id" id="tarea_id" value="">
                        <div class="mb-3">
                            <label for="modificar_tarea" class="form-label">Nombre de tarea:</label>
                            <input type="text" class="form-control" id="modificarNombre" name="modificarNombre"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="modificar_descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="modificar_descripcion" name="modificar_descripcion" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="btn-modificarTarea"
                        onclick="modificarTarea()">Modificar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA --}}
    <div id="tableView" class="table-responsive">

        <div class="table-responsive">
            <table id="data-table-default" width="100%" class="table table-bordered align-middle text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Horas totales este mes</th>
                        <th>Horas totales</th>
                        <th>Detalles</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($lugar->tareas as $tarea)
                        <tr>

                            <td>{{ $tarea->TAR_id }}</td>
                            <td>{{ $tarea->TAR_nombre }}</td>
                            <td>{{ $tarea->TAR_descripcion }}</td>
                            <td>{{ $tarea->horasTotalesTareaMes() }}</td>
                            <td>{{ $tarea->horasTotalesTareaAnioActual() }}</td>
                            <td>
                                <a href="{{ route('tareas.show', ['tarea' => $tarea]) }}" class="btn btn-primary">Ver
                                    Detalles</a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary"
                                    onclick="openModificarModal('{{ $tarea->TAR_id }}','{{ $tarea->TAR_nombre }}', '{{ $tarea->TAR_descripcion }}')">Modificar</button>
                            </td>
                            <td>
                                <div style="position: relative;">
                                    <form id="deleteForm" action="{{ route('tareas.destroy', ['tarea' => $tarea]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger"
                                            onclick="eliminarTarea('{{ $tarea->TAR_id }}')">Eliminar Tarea</button>

                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <link href="{{ asset('css/blog/card.list.css') }}" rel="stylesheet" />
    <!-- CSS de DataTables -->
    <link href="{{ asset('tabla/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('tabla/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-select/js/dataTables.select.min.js') }}"></script>



    <script>
        function confirmDeleteLugar() {
            Swal.fire({
                title: '¿Estás seguro de que deseas eliminar este lugar?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar',
                focusCancel: true, // Foco en el botón de cancelar
                customClass: {
                    confirmButton: 'swal-confirm-btn',
                    cancelButton: 'swal-cancel-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        '¡Eliminado!',
                        'El voluntario ha sido eliminado.',
                        'success'
                    ).then(() => {
                        // Enviar el formulario después de mostrar el mensaje de éxito
                        document.getElementById('deleteFormLugar').submit();
                    });
                }
            })
        }
    </script>
    {{-- SCRIPT PARA AGREGAR TAREA --}}
    <script>
        // Inicializa el DataTable
        let table = $('#data-table-default').DataTable({
            responsive: true,
            select: false,
            "order": [
                [0, 'desc'] // Ordena por la primera columna (created_at) de forma descendente
            ]
        });

        function agregarTarea() {
            // Recolecta los datos del formulario
            let TAR_nombre = $('#nueva_tarea').val();
            let TAR_descripcion = $('#descripcion').val();
            let TAR_lugar_id = $('#lugar').val();

            // Envía los datos al servidor utilizando AJAX
            $.ajax({
                url: "{{ route('tareas.store') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    TAR_nombre: TAR_nombre,
                    TAR_descripcion: TAR_descripcion,
                    TAR_lugar_id: TAR_lugar_id
                },
                success: function(response) {
                    // Muestra el modal de SweetAlert de éxito
                    swal({
                        title: '¡Éxito!',
                        text: 'La tarea ha sido añadida correctamente.',
                        icon: 'success',
                        buttons: {
                            confirm: {
                                text: 'OK',
                                value: true,
                                visible: true,
                                className: 'btn btn-primary',
                                closeModal: true,

                            }
                        }
                    }).then((value) => {
                        // Cuando el usuario haga clic en el botón "OK", recargar la página
                        if (value) {
                            location.reload();
                        }
                    });

                    // Cierra el modal después de agregar la tarea
                    $('#modal-dialog-tarea').modal('hide');

                    $('#modal-dialog-tarea .modal-body #nueva_tarea').empty();
                    $(
                        '#modal-dialog-tarea .modal-body #descripcion').empty();
                    $(
                        '#modal-dialog-tarea .modal-body #lugar').empty();


                    // Recargar la página actual




                },
                error: function(xhr, status, error) {
                    // Maneja cualquier error que ocurra durante la solicitud AJAX
                    console.error('mal');
                }
            });



        }
    </script>

    {{-- IMPORTANTE PARA PODER ELIMINAR --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    {{-- SCRIPT PARA MODIFICAR TAREA --}}
    <script>
        // Inicializa el DataTable



        function modificarTarea() {
            // Recolecta los datos del formulario
            let tarea_id = $('#tarea_id').val();
            let nueva_tarea = $('#modificarNombre').val();
            let nueva_descripcion = $('#modificar_descripcion').val();



            // Envía los datos al servidor utilizando AJAX
            $.ajax({
                url: "{{ route('tareas.update') }}",
                method: "PUT",
                data: {
                    _token: "{{ csrf_token() }}",
                    tarea_id: tarea_id,
                    nueva_tarea: nueva_tarea,
                    nueva_descripcion: nueva_descripcion
                },
                success: function(response) {
                    // Muestra el modal de SweetAlert de éxito
                    swal({
                        title: '¡Éxito!',
                        text: 'La tarea ha sido modificada correctamente.',
                        icon: 'success',
                        buttons: {
                            confirm: {
                                text: 'OK',
                                value: true,
                                visible: true,
                                className: 'btn btn-primary',
                                closeModal: true,
                            }
                        }
                    }).then((value) => {
                        // Cuando el usuario haga clic en el botón "OK", recargar la página
                        if (value) {
                            location.reload();
                        }
                    });

                    // Cierra el modal después de modificar la tarea
                    $('#modal-dialog-modificar-tarea').modal('hide');
                },
                error: function(xhr, status, error) {
                    // Maneja cualquier error que ocurra durante la solicitud AJAX
                    console.error('Error al modificar tarea');
                }
            });
        }
    </script>


    {{-- SCRIPT PARA BORRAR TAREA --}}
    <script>
        function eliminarTarea(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!',
                cancelButtonText: 'Cancelar',
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').action = "/tareas/" + id;
                    document.getElementById('deleteForm').submit();
                }
            })
        }
    </script>

    <script>
        function openModificarModal(tarea_id, nombre, descripcion) {
            $('#modal-dialog-modificar-tarea').modal('show'); // Abre el modal

            // Llena los campos del formulario con los datos de la tarea seleccionada
            $('#modal-dialog-modificar-tarea #tarea_id').val(tarea_id);
            $('#modal-dialog-modificar-tarea #modificarNombre').val(nombre);
            $('#modal-dialog-modificar-tarea #modificar_descripcion').val(descripcion);
        }
    </script>

</x-layout>
