<x-layout>

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
    <div class="d-grid gap-2 mb-3">
        <button id="toggleViewButton" class="btn btn-primary">Cambiar Vista</button>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

   <!-- Tarjetas de coordinadores con estilo unificado -->
   <div id="cardView" class="row mt-5">
    @foreach ($coordinadores as $coordinador)
        <div class="col col-custom mb-4">
        <div class="card h-100 border-0 shadow-sm card-coordinador">
                <a href="{{ route('coordinadores.show', ['coordinadore' => $coordinador]) }}">
                    <img src="{{ $coordinador->imagenPerfil ? $coordinador->imagenPerfil->IMG_path : 'https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1095249842.jpg' }}"
                         class="card-img-top" alt="Imagen de perfil del coordinador">
                </a>
                <div class="card-body">
                    @php
                        $nombre = $coordinador->COO_nombre;
                        $posicionEspacio = strpos($nombre, ' ');
                        if ($posicionEspacio !== false && $posicionEspacio <= 7) {
                            $nombreFinal = substr($nombre, 0, $posicionEspacio) . '<br>' . substr($nombre, $posicionEspacio + 1);
                        } else {
                            $nombreFinal = $nombre;
                        }
                    @endphp
                    <h5 class="card-title">
                        <i class="fas fa-user"></i> {!! $nombreFinal !!}
                    </h5>
                    <p class="card-text">
                        <i class="fas fa-id-card"></i> DNI: {{ $coordinador->COO_dni }}
                    </p>
                    <div class="volunteer-card-buttons d-flex justify-content-center mt-3">
                        <a href="{{ route('coordinadores.show', ['coordinadore' => $coordinador]) }}"
                           class="coordinator-info btn btn-primary">Más información</a>
                        <a href="{{ route('coordinadores.edit', ['coordinadore' => $coordinador]) }}"
                           class="coordinator-modify btn btn-primary">Modificar</a>
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

    <div id="tableView" class="table-responsive " style="display: none;">
        <!-- Contenido de la vista de tabla -->
        <div class="table-responsive">
            <table id="data-table-default" width="100%" class="table table-bordered align-middle text-nowrap">
                <thead>
                    <tr>
                        <th width="1%">ID</th>
                        <th width="1%">Nombre</th>
                        <th width="1%">Apellidos</th>
                        <th>DNI</th>
                        <th>Fecha de Creación</th>
                        <th>Fecha de Actualización</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coordinadores as $coordinador)
                        <tr>
                            <td>{{ $coordinador->COO_id }}</td>
                            <td>{{ $coordinador->COO_nombre }}</td>
                            <td>{{ $coordinador->COO_apellidos }}</td>
                            <td>{{ $coordinador->COO_dni }}</td>
                            <td>{{ $coordinador->created_at }}</td>
                            <td>{{ $coordinador->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($coordinadores->count() > 0)
        <div class="paginacion" id="paginacion">
            {{ $coordinadores->links() }}
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

        // Array para almacenar las IDs de los coordinadores seleccionados
        let coordinadoresSeleccionados = [];

        // Agregar evento de escucha para la selección de filas
        $('#data-table-default tbody').on('click', 'tr', function() {
            // Obtener la ID del coordinador seleccionado
            let coordinadorId = table.row(this).data()[0];

            // Verificar si la ID del coordinador ya está en el array
            let index = coordinadoresSeleccionados.indexOf(coordinadorId);

            // Si la ID no está en el array, agregarla
            if (index === -1) {
                coordinadoresSeleccionados.push(coordinadorId);
            }

            // Imprimir el array de IDs de coordinadores seleccionados
            console.log("Coordinadores seleccionados:", coordinadoresSeleccionados);

            // Puedes hacer lo que necesites con el array aquí
            // Por ejemplo, si quieres almacenarlo en un campo oculto como una cadena JSON
            $('#coordinadoresSeleccionados').val(JSON.stringify(coordinadoresSeleccionados));
            console.log($('#coordinadoresSeleccionados').val());
        });
    </script>
    <script src="{{ asset('js/card-table/switchCardTable.js') }}"></script>


</x-layout>
