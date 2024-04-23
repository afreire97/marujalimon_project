<div class="d-grid gap-2 mb-3">
    <button id="toggleViewButton" class="btn btn-primary">Cambiar Vista</button>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Tarjetas de voluntarios con nuevo estilo -->
<div id="cardView" class="row row-cols-md-3 row-cols-lg-4 gx-1 mt-5">
    @foreach ($voluntarios as $voluntario)
    <div class="col mb-4">
        <!-- Tarjeta con nuevo estilo -->
        <div class="card h-100 border-0 shadow-sm" data-tilt>
            <!-- Imagen de perfil del voluntario -->
            <img src="{{ $voluntario->imagenPerfil
                    ? $voluntario->imagenPerfil->IMG_path
                    : 'data:image/svg+xml,%3Csvg
                                                                                        xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 448 512\'%3E%3Cpath
                                                                                        fill=\'%23999\' d=\'M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96
                                                                                        57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.4-46.6 16-72.9
                                                                                        16s-50.7-5.6-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48
                                                                                        48 48h352c26.5 0 48-21.5
                                                                                        48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z\'/%3E%3C/svg%3E' }}" class="card-img-top" alt="Imagen de perfil del voluntario">

            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-user"></i> {{ $voluntario->VOL_nombre }} {{ $voluntario->VOL_apellidos }}
                </h5>
                <p class="card-text">
                    <i class="fas fa-id-card"></i> DNI: {{ $voluntario->VOL_dni }}
                </p>
                <a href="{{ route('voluntarios.show', ['voluntario' => $voluntario]) }}" class="btn btn-primary" style="margin-right: 12px;">Más información</a>
                <a href="{{ route('voluntario.edit_form', ['voluntario' => $voluntario]) }}" class="btn btn-primary ">Modificar</a>
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

<div id="addHoursForm">
    <form action="{{ route('horas.añadir') }}" method="POST">
        @csrf
        <input type="hidden" name="voluntarioId" id="voluntarioId" value="">

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
                @foreach ($voluntarios as $voluntario)
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

<div class="paginacion" id="paginacion">
    {{ $voluntarios->links() }}
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('tabla/assets/plugins/datatables.net-select/js/dataTables.select.min.js') }}"></script>
<script>
    console.log("Inicializando DataTables...");

    let table = $('#data-table-default').DataTable({
        responsive: true,
        select: true,
    });

    // Agregar evento de escucha para la selección de filas
    $('#data-table-default tbody').on('click', 'tr', function() {

        console.log("Voluntario seleccionado: " + voluntarioId);
        $('#voluntarioId').val(table.row(this).data()[0]);

    });
</script>
<script src="{{ asset('js/card-table/switchCardTable.js') }}"></script>