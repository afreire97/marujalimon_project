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






    <!-- Tarjetas de lugares con nuevo estilo -->
    <div id="cardView" class="row mt-5">

        @if ($lugares)

            @foreach ($lugares as $lugar)
                <div class="col col-custom mb-4">
                    <div class="card h-100 border-0 shadow-sm" id="cardViewLugar">
                        <!-- Start of clickable image -->
                        <a href="{{ route('lugares.show', ['lugar' => $lugar]) }}">
                            <img src="{{ optional($lugar->imagen)->IMG_path ? $lugar->imagen->IMG_path : asset('img/default_img/lugar.png') }}"
                                class="volunteer-card-img">

                        </a>
                        <!-- End of clickable image -->

                        <div class="volunteer-card-body">
                            <h5 class="volunteer-card-title mt-3">
                                <i class="fas fa-user"></i> {{ $lugar->LUG_nombre }}
                            </h5>

                            <p></p>
                            @if ($lugar->LUG_direccion)
                                <p class="text-break">
                                    <i class="fas fa-id-card"></i> Dirección: {{ $lugar->LUG_direccion }}
                                </p>
                            @endif

                            @if ($lugar->LUG_provincia)
                                <p class="text-break">
                                    <i class="fas fa-id-card"></i> Provincia: {{ $lugar->LUG_provincia }}
                                </p>
                            @endif

                            @if ($lugar->LUG_localidad)
                                <p class="text-break">
                                    <i class="fas fa-id-card"></i> Localidad: {{ $lugar->LUG_localidad }}
                                </p>
                            @endif
                            <p>
                                <a target="_blank" href="{{ $lugar->LUG_url_maps }}">Visitar sitio</a>
                            </p>
                            <div class="volunteer-card-buttons">
                                <a href="{{ route('lugares.show', ['lugar' => $lugar]) }}"
                                    class="volunteer-info btn btn-primary">Más información</a>
                                <a href="{{ route('lugares.edit', ['lugar' => $lugar]) }}"
                                    class="volunteer-modify btn btn-primary">Modificar</a>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>


    {{-- MODAL PARA AÑADIR COORDINADORES A UN LUGAR --}}
    <div class="modal fade" id="modal-dialog-tarea">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #008080; display: flex; justify-content: center; align-items: center;">
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
                    } if(!data.success) {
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


</x-layout>
