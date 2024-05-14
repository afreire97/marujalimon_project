<x-layout>





    <div class="mode-container"
        style="display: flex; align-items: center; justify-content: space-between; background-color: #008080; padding: 10px; border-radius: 5px; width: 100%;">
        <div style="flex-grow: 1; display: flex; justify-content: center;">
            <div id="modeDisplay" class="text-position" style="color: white; font-size: 24px;">Lugares</div>
        </div>
        <div class="button-container d-flex justify-content-end align-items-center">
            <div class="container d-flex justify-content-end">
                <div class="row">
                    <div class="col">
                        <a href="#modal-dialog-tarea" class="btn btn-warning" id="tareaButton"
                            data-bs-toggle="modal">Asignar cordinador/es a un lugar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="search" placeholder="Buscar por nombre de lugar, dirección, provincia o localidad.">
    <style>
        #search {
            width: 24%;
            /* Ajusta el tamaño de la barra de búsqueda */
            margin-left: auto;
            /* Centra la barra de búsqueda a la izquierda */
            margin-right: auto;
            /* Centra la barra de búsqueda a la izquierda */
            margin-top: 0.5rem;
            /* Reduce el margen superior de la barra de búsqueda */
        }

        #cardView {
            margin-top: 0;
            /* Elimina el margen superior de las tarjetas */
        }
    </style>


    <div id="cardView" class="row mt-5">
        <!-- Las tarjetas de los lugares se cargarán aquí dinámicamente -->
    </div>

    <div id="pagination" class="pagination-controls">
        <button id="prevPage">Anterior</button>
        <span id="pageInfo"></span>
        <button id="nextPage">Siguiente</button>
    </div>




    <!-- Tarjetas de lugares con nuevo estilo -->



    {{-- MODAL PARA AÑADIR COORDINADORES A UN LUGAR --}}
    <div class="modal fade" id="modal-dialog-tarea">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header"
                    style="background-color: #008080; display: flex; justify-content: center; align-items: center;">
                    <h4 class="modal-title">Asignar cordinador/es a un lugar</h4>
                </div>
                <div class="modal-body">
                    <!-- Formulario de añadir tarea -->
                    <form id="form-agregar-tarea" method="POST" action="{{ route('asignarCoordinador') }}">
                        @csrf



                        @if (auth()->user()->is_coordinador)
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Lugares</label>
                                <select name="LUG_COO_id" id="LUG_COO_id" required>
                                    @foreach ($lugaresAll as $lugar)
                                        <option value="{{ $lugar->LUG_id }}">{{ $lugar->LUG_nombre }}</option>
                                    @endforeach
                                </select>
                            </div>


                        @endif

                        @if (auth()->user()->is_admin)

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Lugares</label>
                                <select name="LUG_id" id="LUG_id" required>
                                    @foreach ($lugares as $lugar)
                                        <option value="{{ $lugar->LUG_id }}">{{ $lugar->LUG_nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion 2" class="form-label">Coordinadores</label>
                                <select name="COO_id[]" id="COO_id" multiple required>
                                    @foreach ($coordinadores as $coordinador)
                                        <option value="{{ $coordinador->COO_id }}">{{ $coordinador->COO_nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                        @endif
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="btn-añadirTarea"
                        onclick="asignarLugar()">Añadir</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#COO_id').select2();
        });
    </script>
    <script>
        function asignarLugar() {
            // Obtener el formulario
            var form = document.getElementById("form-agregar-tarea");

            // Enviar el formulario mediante fetch
            fetch(form.action, {
                    method: form.method,
                    body: new FormData(form)
                })
                .then(function(response) {

                    // Si la respuesta del servidor es exitosa, muestra un mensaje de éxito
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        swal({
                            title: '¡Éxito!',
                            text: 'El lugar ha sido asignado correctamente.',
                            icon: 'success',
                            buttons: {
                                confirm: {
                                    text: 'OK',
                                    value: true,
                                    visible: true,
                                    className: 'btn btn-primary reload',
                                    closeModal: true,
                                }
                            }
                        }).then(function() {
                            // Cuando el usuario haga clic en el botón "OK", recargar la página
                            location.reload();
                        });
                        $('#modal-dialog').modal('hide');
                    }
                    if (!data.success) {
                        swal({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            button: 'Ok'
                        }).then(function() {
                            // Cuando el usuario haga clic en el botón "OK", recargar la página
                            location.reload();
                        });
                    }
                });

        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let allPlaces = [];
            let currentPage = 1;
            const placesPerPage = 32;
            const cardsContainer = document.getElementById('cardView');
            let currentSearch = ''; // Almacena la búsqueda actual
            let abortController = new AbortController(); // Controlador para abortar fetch

            async function displayPlaces(places) {
                const startIndex = (currentPage - 1) * placesPerPage;
                const endIndex = startIndex + placesPerPage;
                const placesToShow = places.slice(startIndex, endIndex);

                cardsContainer.innerHTML = ''; // Limpia el contenedor

                for (const place of placesToShow) {
                    const imagePath = place.IMG_path ? place.IMG_path : 'img/default_img/lugar.png';
                    const placeCard = document.createElement('div');
                    placeCard.className = 'col col-custom mb-4';
                    placeCard.innerHTML = `
            <div class="card h-100 border-0 shadow-sm" id="cardViewLugar">
                    <a href="/lugares/${place.LUG_id}">
                        <img src="${imagePath}" class="volunteer-card-img" alt="Imagen del lugar">
                    </a>
                    <div class="volunteer-card-body">
                        <h5 class="volunteer-card-title mt-3">
                            <i class="fas fa-map-marker-alt"></i> ${place.LUG_nombre}
                        </h5>
                        <p class="text-break"><i class="fas fa-map-signs"></i> Dirección: ${place.LUG_direccion}</p>
                        ${place.LUG_provincia ? `<p class="text-break"><i class="fas fa-location-arrow"></i> Provincia: ${place.LUG_provincia}</p>` : ''}
                        ${place.LUG_localidad ? `<p class="text-break"><i class="fas fa-city"></i> Localidad: ${place.LUG_localidad}</p>` : ''}
                        <p>
                            <a target="_blank" href="${place.LUG_url_maps}"><i class="fas fa-external-link-alt"></i> Visitar en Maps</a>
                        </p>
                        <div class="volunteer-card-buttons">
                            <a href="/lugares/${place.LUG_id}" class="volunteer-info btn btn-primary"><i class="fas fa-info-circle"></i> Más información</a>
                            <a href="/lugares/${place.LUG_id}/edit" class="volunteer-modify btn btn-primary"><i class="fas fa-edit"></i> Modificar</a>
                        </div>
                    </div>
                </div>
            `;
                    cardsContainer.appendChild(placeCard);
                }

                updatePaginationControls(places.length);
            }

            function updatePaginationControls(totalPlaces) {
                const pageInfo = document.getElementById('pageInfo');
                const totalPages = Math.ceil(totalPlaces / placesPerPage);
                pageInfo.textContent = `Página ${currentPage} de ${totalPages}`;
                document.getElementById('prevPage').disabled = currentPage === 1;
                document.getElementById('nextPage').disabled = currentPage === totalPages;
            }

            document.getElementById('prevPage').addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    displayPlaces(currentSearch ? filteredPlaces : allPlaces);
                }
            });

            document.getElementById('nextPage').addEventListener('click', function() {
                if (currentPage * placesPerPage < allPlaces.length) {
                    currentPage++;
                    displayPlaces(currentSearch ? filteredPlaces : allPlaces);
                }
            });

            fetch('/api/lugares')
                .then(response => response.json())
                .then(data => {
                    allPlaces = data; // Asumiendo que la API devuelve un arreglo de lugares
                    displayPlaces(allPlaces);
                });

            document.getElementById('search').addEventListener('keyup', function(e) {


                currentSearch = e.target.value.toLowerCase();
                // Filtra los lugares basándose en múltiples campos


                const filteredPlaces = allPlaces.filter(place =>
                    place.LUG_nombre.toLowerCase().includes(currentSearch) ||
                    place.LUG_direccion.toLowerCase().includes(currentSearch) ||
                    (place.LUG_provincia && place.LUG_provincia.toLowerCase().includes(
                    currentSearch)) ||
                    (place.LUG_localidad && place.LUG_localidad.toLowerCase().includes(currentSearch))
                );
                currentPage = 1;
                abortController.abort(); // Cancela cualquier solicitud fetch en progreso
                abortController =
            new AbortController(); // Crea un nuevo controlador para futuras solicitudes
                displayPlaces(filteredPlaces);
            });

        });
    </script>


</x-layout>
