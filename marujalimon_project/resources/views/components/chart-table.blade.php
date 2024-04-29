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
                           class="volunteer-btn-primary btn btn-primary">Más información</a>
                        <a href="{{ route('voluntario.edit_form', ['voluntario' => $voluntario]) }}"
                           class="volunteer-btn-primary btn btn-primary">Modificar</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>



@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


<div id="addHoursForm">
    <form action="{{ route('horas.añadir') }}" method="POST">
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

        <button type="submit">Agregar</button>
    </form>
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
<script>
    console.log("Inicializando DataTables...");

    let table = $('#data-table-default').DataTable({
        responsive: true,
        select: {
            style: 'multi'
        }
    });

    // Array para almacenar las IDs de los voluntarios seleccionados
    let voluntariosSeleccionados = [];

    // Agregar evento de escucha para la selección de filas
    $('#data-table-default tbody').on('click', 'tr', function() {
        // Obtener la ID del voluntario seleccionado
        let voluntarioId = table.row(this).data()[0];

        // Verificar si la ID del voluntario ya está en el array
        let index = voluntariosSeleccionados.indexOf(voluntarioId);

        // Si la ID no está en el array, agregarla
        if (index === -1) {
            voluntariosSeleccionados.push(voluntarioId);
        }

        // Imprimir el array de IDs de voluntarios seleccionados
        console.log("Voluntarios seleccionados:", voluntariosSeleccionados);

        // Puedes hacer lo que necesites con el array aquí
        // Por ejemplo, si quieres almacenarlo en un campo oculto como una cadena JSON
        $('#voluntariosSeleccionados').val(JSON.stringify(voluntariosSeleccionados));
        console.log($('#voluntariosSeleccionados').val());
    });
</script>
<script src="{{ asset('js/card-table/switchCardTable.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var toggleButton = document.getElementById('toggleViewButton');
    var addNuevaTareaForm = document.getElementById('addNuevaTarea');
    var addHoursForm = document.getElementById('addHoursForm');
    
    // Assume that we start in the card view
    var isCardView = true;

    toggleButton.addEventListener('click', function() {
        // Toggles a class on the body (or other logic you may have) to change the view
        document.body.classList.toggle('cards-view');

        // Toggle the state
        isCardView = !isCardView;

        // Based on the view, show or hide forms
        addNuevaTareaForm.style.display = isCardView ? 'none' : 'block';
        addHoursForm.style.display = isCardView ? 'none' : 'block'; // Or 'none' if you want this form to stay hidden
    });
});
</script>