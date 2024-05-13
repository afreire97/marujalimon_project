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




    <div class="mode-container" style="display: flex; align-items: center; justify-content: space-between; background-color: #008080; padding: 10px; border-radius: 5px; width: 100%;">
    <div style="flex-grow: 1; display: flex; justify-content: center;">
    <div id="modeDisplay" style="color: white; font-size: 24px;">Coordinadores</div>
    </div>




    <button id="toggleViewButton" class="btn btn-danger">Cambiar a Tabla</button>
</div>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    #search {
        width: 11%; /* Ajusta el tamaño de la barra de búsqueda */
        margin-left: auto; /* Centra la barra de búsqueda a la izquierda */
        margin-right: auto; /* Centra la barra de búsqueda a la izquierda */
        margin-top: 0.5rem; /* Reduce el margen superior de la barra de búsqueda */
    }
    #cardView {
        margin-top: 0; /* Elimina el margen superior de las tarjetas */
    }
</style>

<input type="text" id="search" placeholder="Buscar por nombre o DNI">
<!-- Tarjetas de coordinadores con estilo unificado -->
<div id="cardView" class="row mt-0">
    <!-- Este contenedor inicialmente está vacío y se llenará dinámicamente mediante JavaScript -->
</div>
<div id="paginationControls">
    <button id="prevPage" disabled>Anterior</button>
    <button id="nextPage" disabled>Siguiente</button>
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
            select: false,

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
    <script>
document.getElementById("toggleViewButton").addEventListener("click", function() {
    var button = document.getElementById("toggleViewButton");
    if (button.innerHTML === "Cambiar a Tabla") {
        button.innerHTML = "Cambiar a Tarjetas";
    } else {
        button.innerHTML = "Cambiar a Tabla";
    }
});
</script>
<script>
// Selecciona el botón y el elemento de entrada
var button = document.getElementById('toggleViewButton');
var input = document.getElementById('search');

// Añade un evento de clic al botón
button.addEventListener('click', function() {
  // Cambia la propiedad de display del elemento de entrada
  if (input.style.display !== 'none') {
    input.style.display = 'none';
  } else {
    input.style.display = '';
  }
});
</script>
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $("#cardView .col").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let allCoordinators = [];
    let currentPage = 1;
    const coordinatorsPerPage = 10; 
    const cardsContainer = document.getElementById('cardView');
    let currentSearch = ''; 
    let abortController = new AbortController(); 

    async function displayCoordinators(coordinators) {
    const startIndex = (currentPage - 1) * coordinatorsPerPage;
    const endIndex = startIndex + coordinatorsPerPage;
    const coordinatorsToShow = coordinators.slice(startIndex, endIndex);

    cardsContainer.innerHTML = '';

    for (const coordinator of coordinatorsToShow) {
        // URL por defecto (placeholder)
        let imageUrl = 'https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1095249842.jpg';
        try {
            const response = await fetch(`/coordinador/${coordinator.COO_id}/imagen-perfil`);
            const data = await response.json();
            if (response.ok && data.success) {
                imageUrl = data.imagenPerfil.IMG_path; // Usando la propiedad IMG_path que contiene la URL de la imagen
            }
        } catch (error) {
            console.error('Failed to fetch profile image:', error);
        }

        const cardHTML = `
        <div class="col col-custom mb-4">
            <div class="card h-100 border-0 shadow-sm card-coordinador">
                <a href="/coordinadores/${coordinator.COO_id}">
                    <img src="${imageUrl}" class="card-img-top" alt="Imagen de perfil del coordinador">
                </a>
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-user-tie"></i> ${coordinator.COO_nombre} ${coordinator.COO_apellidos}</h5>
                    <p class="card-text"> <i class="fas fa-id-card"></i> DNI: ${coordinator.COO_dni}</p>
                    <div class="volunteer-card-buttons d-flex justify-content-center mt-3">
                        <a href="/coordinadores/${coordinator.COO_id}" class="coordinator-info btn btn-primary">Más información</a>
                        <a href="/coordinadores/${coordinator.COO_id}/edit" class="coordinator-modify btn btn-primary">Modificar</a>
                    </div>
                </div>
            </div>
        </div>
        `;
        cardsContainer.innerHTML += cardHTML;
    }

    updatePaginationControls(coordinators);
}



    function updatePaginationControls(coordinators) {
        const totalPages = Math.ceil(coordinators.length / coordinatorsPerPage);
        document.getElementById('prevPage').disabled = currentPage === 1;
        document.getElementById('nextPage').disabled = currentPage === totalPages;
    }

    document.getElementById('prevPage').addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            displayCoordinators(allCoordinators);
        }
    });

    document.getElementById('nextPage').addEventListener('click', function() {
        if (currentPage * coordinatorsPerPage < allCoordinators.length) {
            currentPage++;
            displayCoordinators(allCoordinators);
        }
    });

    fetch('/api/coordinadores')
        .then(response => response.json())
        .then(data => {
            allCoordinators = data;
            displayCoordinators(allCoordinators); 
        });

    document.getElementById('search').addEventListener('keyup', function(e) {
        currentSearch = e.target.value.toLowerCase();
        const filteredCoordinators = allCoordinators.filter(coordinator =>
            coordinator.COO_nombre.toLowerCase().includes(currentSearch) ||
            coordinator.COO_apellidos.toLowerCase().includes(currentSearch) ||
            coordinator.COO_dni.toLowerCase().includes(currentSearch)
        );
        currentPage = 1; 
        abortController.abort(); 
        abortController = new AbortController(); 
        displayCoordinators(filteredCoordinators);
    });
});
</script>





</x-layout>
