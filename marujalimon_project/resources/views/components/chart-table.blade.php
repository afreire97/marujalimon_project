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





<div>
    <div class="container d-flex justify-content-end mb-2">
        <div class="row">
            <div class="col">
                <a href="#modal-dialog" class="btn btn-sm btn-success" data-bs-toggle="modal" id="demoButton"
                    style="display: none;">Añadir horas</a>

            </div>
        </div>
    </div>

    <!-- Botón "Añadir tarea" -->


</div>

<!-- Botón "Demo" -->


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

                    <div id="voluntarios-seleccionados"></div>


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
                <a href="javascript:;" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</a>
                <button type="button" class="btn btn-success" id="btn-agregar"
                    onclick="agregarHoras()">Agregar</button>


            </div>
        </div>
    </div>
</div>



<!-- Modal de añadir tarea -->



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

        // Assume that we start in the card view
        var isCardView = true;

        toggleButton.addEventListener('click', function() {
            // Toggles a class on the body (or other logic you may have) to change the view
            document.body.classList.toggle('cards-view');

            // Toggle the state
            isCardView = !isCardView;

            // Based on the view, show or hide forms
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
    let voluntariosNombres = [];

    $('#data-table-default tbody').on('click', 'tr', function() {
        let voluntarioId = table.row(this).data()[0];
        let voluntarioNombre = table.row(this).data()[1];

        let index = voluntariosSeleccionados.indexOf(voluntarioId);

        if (index === -1) {
            voluntariosSeleccionados.push(voluntarioId);
            voluntariosNombres.push(voluntarioNombre);
        } else {
            voluntariosSeleccionados.splice(index, 1);
            voluntariosNombres.splice(index, 1);
        }

        console.log("Voluntarios seleccionados:", voluntariosSeleccionados);
        console.log("Voluntarios nombres:", voluntariosNombres);

        $('#modal-dialog .modal-body #voluntarios-seleccionados').empty();

        // Agrega los nombres de los voluntarios seleccionados al div en el cuerpo del modal
        voluntariosNombres.forEach(nombre => {
            $('#modal-dialog .modal-body #voluntarios-seleccionados').append(
                '<p>Voluntario seleccionado: ' + nombre + '</p>');
        });

    });

    function agregarHoras() {
        // Recolecta los voluntarios seleccionados
        let voluntariosSeleccionadosJSON = JSON.stringify(voluntariosSeleccionados);

        // Verifica si el array de voluntarios seleccionados está vacío
        if (voluntariosSeleccionados.length === 0) {
            // Muestra el modal de SweetAlert como warning
            swal({
                title: 'Aviso',
                text: 'Es necesario seleccionar al menos un voluntario antes de añadir horas.',
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
                        title: '¡Éxito!',
                        text: 'Las horas han sido añadidas.',
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggleButton = document.getElementById('toggleViewButton');
        var demoButton = document.getElementById('demoButton'); // Referencia al botón "Demo"
        var botonTarea = document.getElementById('tareaButton');

        // Asumimos que empezamos en la vista de tarjetas
        var isCardView = true;

        toggleButton.addEventListener('click', function() {
            // Cambia una clase en el cuerpo (u otra lógica que puedas tener) para cambiar la vista
            document.body.classList.toggle('cards-view');

            // Alterna el estado
            isCardView = !isCardView;

            // Basado en la vista, muestra u oculta formularios

            // Alterna la visibilidad del botón "Demo"
            demoButton.style.display = isCardView ? 'none' :
                'block'; // Esto asegura que el botón solo aparezca en la vista de tabla
            botonTarea.style.display = isCardView ? 'none' : 'block';
        });
    });
</script>
