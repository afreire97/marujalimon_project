<div class="d-grid gap-2 mb-3">
    <button id="toggleViewButton" class="btn btn-primary">Cambiar Vista</button>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Tarjetas de voluntarios con nuevo estilo -->
<div id="cardView" class="row mt-5">
    @foreach ($voluntarios as $voluntario)
        <div class="col col-custom mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <!-- Start of clickable image -->
                <a href="{{ route('voluntarios.show', ['voluntario' => $voluntario]) }}">
                    <img src="{{ $voluntario->imagenPerfil ? $voluntario->imagenPerfil->IMG_path : 'https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1095249842.jpg' }}"
                        class="volunteer-card-img" alt="Imagen de perfil del voluntario">
                </a>
                <!-- End of clickable image -->

                <div class="volunteer-card-body">
                    <h5 class="volunteer-card-title">
                        <i class="fas fa-user"></i> {{ $voluntario->VOL_nombre }} {{ $voluntario->VOL_apellidos }}
                    </h5>
                    <p class="volunteer-card-text">
                        <i class="fas fa-id-card"></i> DNI: {{ $voluntario->VOL_dni }}
                    </p>
                    <div class="volunteer-card-buttons">
                        <a href="{{ route('voluntarios.show', ['voluntario' => $voluntario]) }}"
                           class="volunteer-info btn btn-primary">Más información</a>
                        <a href="{{ route('voluntarios.edit', ['voluntario' => $voluntario]) }}"
                           class="volunteer-modify btn btn-primary">Modificar</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>






<div id="addNuevaTarea">
    <form action="{{ route('tareas.agregar') }}" method="POST">
        @csrf
        <input type="hidden" name="voluntariosSeleccionados" id="voluntariosSeleccionados" value="">

        <label for="nueva_tarea">Nueva tarea:</label>
        <input type="text" name="nueva_tarea" id="nueva_tarea" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required></textarea>

        <label for="tarea_id">Lugares disponibles:</label>
        <select name="tarea_id" id="tarea_id" required>
            @foreach ($lugares as $lugar)
                <option value="{{ $lugar->LUG_id }}">{{ $lugar->LUG_nombre }}</option>
            @endforeach
        </select>

        <button type="submit">Agregar</button>
    </form>
</div>


<!-- Botón "Demo" -->
<div class="container d-flex justify-content-end">
    <div class="row">
        <div class="col">
            <a href="#modal-dialog" class="btn btn-sm btn-success" data-bs-toggle="modal">Añadir horas</a>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Añadir horas</h4>
            </div>
            <div class="modal-body">
                <!-- Aquí está el formulario -->
                <form>
                    @csrf
                    <input type="hidden" name="voluntariosSeleccionados" id="voluntariosSeleccionados" value="">

                    <label for="horas">Horas:</label>
                    <input type="number" name="horas" id="horas" required>

                    <label for="tarea_id">Tarea:</label>
                    <select name="tarea_id" id="tarea_id" required>
                        @foreach ($tareas as $tarea)
                            <option value="{{ $tarea->TAR_id }}">{{ $tarea->TAR_nombre }}</option>
                        @endforeach
                    </select>

                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
                <button type="button" class="btn btn-success" id="btn-agregar" onclick="agregarHoras()">Agregar</button>


            </div>
        </div>
    </div>
</div>




<div id="tableView" class="table-responsive " style="display: none;">
    <!-- Contenido de la vista de tabla -->
    <div class="table-responsive">
        <table id="data-table-default" width="100%" class="table table-bordered align-middle text-nowrap">
            <thead>
                <tr>
                    <th width="1%">ID</th>
                    <th width="1%">Nombre</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Domicilio</th>
                    <th>Código Postal</th>
                    <th>Teléfono</th>
                    <th>Sexo</th>
                    <th>Correo Electrónico</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($voluntarios_all as $voluntario)
                    <tr>
                        <td>{{ $voluntario->VOL_id }}</td>
                        <td>{{ $voluntario->VOL_nombre }}</td>
                        <td>{{ $voluntario->VOL_apellidos }}</td>
                        <td>{{ $voluntario->VOL_dni }}</td>
                        <td>{{ $voluntario->VOL_fecha_nac }}</td>
                        <td>{{ $voluntario->VOL_domicilio }}</td>
                        <td>{{ $voluntario->VOL_cp }}</td>
                        <td>{{ $voluntario->VOL_tel1 }}</td>
                        <td>{{ $voluntario->VOL_sexo }}</td>
                        <td>{{ $voluntario->VOL_mail }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if ($voluntarios->count() > 0)
    <div class="paginacion" id="paginacion">
        {{ $voluntarios->links() }}
    </div>
@endif


















<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('tabla/assets/plugins/datatables.net-select/js/dataTables.select.min.js') }}"></script>

<script src="{{ asset('js/card-table/switchCardTable.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggleButton = document.getElementById('toggleViewButton');
        var addNuevaTareaForm = document.getElementById('addNuevaTarea');

        // Assume that we start in the card view
        var isCardView = true;

        toggleButton.addEventListener('click', function() {
            // Toggles a class on the body (or other logic you may have) to change the view
            document.body.classList.toggle('cards-view');

            // Toggle the state
            isCardView = !isCardView;

            // Based on the view, show or hide forms
            addNuevaTareaForm.style.display = isCardView ? 'none' : 'block';
        });
    });
</script>
<script>
    console.log("Inicializando DataTables...");

    let table = $('#data-table-default').DataTable({
        responsive: true,
        select: {
            style: 'multi'
        }
    });

    let voluntariosSeleccionados = [];

    $('#data-table-default tbody').on('click', 'tr', function() {
        let voluntarioId = table.row(this).data()[0];
        let index = voluntariosSeleccionados.indexOf(voluntarioId);

        if (index === -1) {
            voluntariosSeleccionados.push(voluntarioId);
        } else {
            voluntariosSeleccionados.splice(index, 1);
        }

        console.log("Voluntarios seleccionados:", voluntariosSeleccionados);
    });

    function agregarHoras() {
    // Recolecta los voluntarios seleccionados
    let voluntariosSeleccionadosJSON = JSON.stringify(voluntariosSeleccionados);

    // Verifica si el array de voluntarios seleccionados está vacío
    if (voluntariosSeleccionados.length === 0) {
        // Muestra el modal de SweetAlert como warning
        swal({
            title: 'Warning',
            text: 'You need to select at least one volunteer before adding hours.',
            icon: 'warning',
            buttons: {
                confirm: {
                    text: 'OK',
                    value: true,
                    visible: true,
                    className: 'btn btn-primary',
                    closeModal: true
                }
            }
        });
    } else {
        // Envía los datos al servidor utilizando AJAX
        $.ajax({
            url: "{{ route('horas.añadir') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                voluntariosSeleccionados: voluntariosSeleccionadosJSON,
                horas: $('#horas').val(),
                tarea_id: $('#tarea_id').val()
            },
            success: function(response) {
                // Muestra el modal de SweetAlert de éxito
                swal({
                    title: 'Success',
                    text: 'Hours added successfully for all selected volunteers.',
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


                $('#modal-dialog').modal('hide');

            },
            error: function(xhr, status, error) {
                // Maneja cualquier error que ocurra durante la solicitud AJAX
                console.error(xhr.responseText);
            }
        });
    }
}


</script>




