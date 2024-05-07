<x-layout>





    <div class="mode-container" style="display: flex; align-items: center; justify-content: space-between; background-color: #008080; padding: 10px; border-radius: 5px; width: 100%;">
        <div style="flex-grow: 1; display: flex; justify-content: center;">
            <div id="modeDisplay" class="text-position" style="color: white; font-size: 24px;">Lugares</div>
        </div>
        <div class="button-container d-flex justify-content-end align-items-center">
            <div class="container d-flex justify-content-end">
                <div class="row">
                    <div class="col">
                        <a href="#modal-dialog-tarea" class="btn btn-warning" id="tareaButton"
                            data-bs-toggle="modal">Asignar nuevo lugar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <!-- Tarjetas de lugares con nuevo estilo -->
    <div id="cardView" class="row mt-5">
        @foreach ($lugares as $lugar)
            <div class="col col-custom mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <!-- Start of clickable image -->
                    <a href="{{ route('lugares.show', ['lugar' => $lugar]) }}">
                        <img src="{{ optional($lugar->imagen)->IMG_path ? asset($lugar->imagen->IMG_path) : asset('img/default_img/lugar.png') }}" class="volunteer-card-img">
                        alt="Imagen de perfil del voluntario">
                    </a>
                    <!-- End of clickable image -->

                    <div class="volunteer-card-body">
                        <h5 class="volunteer-card-title">
                            <i class="fas fa-user"></i> {{ $lugar->LUG_nombre }}
                        </h5>
                        <p class="volunteer-card-text">
                            <i class="fas fa-id-card"></i> Dirección: {{ $lugar->LUG_direccion }}
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
    </div>




    {{-- MODAL PARA AÑADIR TAREA --}}
    <div class="modal fade" id="modal-dialog-tarea">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Añadir lugar de trabajo</h4>
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
                                <select name="COO_id" id="COO_id" required>
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
        function asignarLugar() {
            // Obtener el formulario
            var form = document.getElementById("form-agregar-tarea");

            // Enviar el formulario mediante fetch
            fetch(form.action, {
                    method: form.method,
                    body: new FormData(form)
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
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
                    } else {
                        swal({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            button: 'Ok'
                        });
                    }
                })
                .catch(function(error) {
                    // Si hay un error en la solicitud, muestra un mensaje de error
                    console.error('Error:', error);
                    swal({
                        title: 'Error',
                        text: 'Hubo un problema al añadir las horas, por favor revisa los datos.',
                        icon: 'error',
                        button: 'Ok'
                    });
                });
        }
    </script>


</x-layout>
