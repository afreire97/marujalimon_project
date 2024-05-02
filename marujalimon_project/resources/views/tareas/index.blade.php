
<x-layout>

    <div class="container d-flex justify-content-end">
        <div class="row">
            <div class="col">
                <a href="#modal-dialog-tarea" class="btn btn-sm btn-success" id="tareaButton" data-bs-toggle="modal">Añadir tarea</a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-dialog-tarea">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Añadir tarea a {{$lugar->LUG_nombre}}</h4>
                </div>
                <div class="modal-body">
                    <!-- Formulario de añadir tarea -->
                    <form>
                        @csrf
                        <input type="hidden" name="voluntariosSeleccionados" id="voluntariosSeleccionados" value="">
                        <input type="hidden" name="lugar" id="lugar" value="{{$lugar->LUG_id}}">

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
                    <button type="button" class="btn btn-success" id="btn-añadirTarea">Añadir</button>
                </div>
            </div>
        </div>
    </div>
    <div id="tableView" class="table-responsive">
        <h2>Tareas de {{$lugar->LUG_nombre}}</h2>
        <div class="table-responsive">
            <table id="data-table-default" width="100%" class="table table-bordered align-middle text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Horas totales este mes</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tareas as $tarea)
                        <tr>

                            <td>{{ $tarea->TAR_id }}</td>
                            <td>{{ $tarea->TAR_nombre }}</td>
                            <td>{{ $tarea->TAR_descripcion }}</td>
                            <td>{{ $tarea->horasTotalesTareaMes() }}</td>
                            <td>
                                <a href="{{ route('tareas.show', ['tarea' => $tarea]) }}" class="btn btn-primary">Ver Detalles</a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <link href="{{ asset('css/blog/card.list.css') }}" rel="stylesheet" />
    <!-- CSS de DataTables -->
    <link href="{{ asset('tabla/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('tabla/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-select/js/dataTables.select.min.js') }}"></script>



    <script>

        let table = $('#data-table-default').DataTable({
            responsive: true,
            select: true,
        });

    </script>

<script>

    $('#btn-añadirTarea').click(function() {
        // Recolecta los datos del formulario
        let TAR_nombre = $('#nueva_tarea').val();
        let TAR_descripcion = $('#descripcion').val();
        let TAR_lugar_id = $('#lugar').val();

        console.log('lugar id: ' . TAR_lugar_id);

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
                });

                // Cierra el modal después de agregar la tarea
                $('#modal-dialog-tarea').modal('hide');

                // Limpiar el formulario después de agregar la tarea (si es necesario)
                $('#nueva_tarea').val('');
                $('#descripcion').val('');
                $('#lugar').val('');
                // O cualquier otro proceso necesario después de agregar la tarea
            },
            error: function(xhr, status, error) {
                // Maneja cualquier error que ocurra durante la solicitud AJAX
                console.error('mal');
            }
        });
    });
</script>



</x-layout>
