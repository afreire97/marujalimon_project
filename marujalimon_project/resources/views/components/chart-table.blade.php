<div class="mode-container" style="display: flex; align-items: center; justify-content: space-between; background-color: #008080; padding: 10px; border-radius: 5px; width: 100%;">
    <div style="flex-grow: 1; display: flex; justify-content: center;">
        <div id="modeDisplay" class="text-position" style="color: white; font-size: 24px;">Voluntarios</div>
    </div>
    <div class="button-container d-flex justify-content-end align-items-center">
        <a href="#modal-dialog" class="btn btn-success" data-bs-toggle="modal" style="display: none;" id="demoButton">Añadir horas</a>
        <button id="toggleViewButton" class="btn btn-danger">Cambiar a Tabla</button>
    </div>
</div>







<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<!-- Tarjetas de voluntarios con nuevo estilo -->
<div id="cardView" class="row mt-5">
    @foreach ($voluntarios as $voluntario)
    <div class="col col-custom mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <!-- Start of clickable image -->
            <a href="{{ route('voluntarios.show', ['voluntario' => $voluntario]) }}">
                <img src="{{ $voluntario->imagenPerfil ? $voluntario->imagenPerfil->IMG_path : 'https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1095249842.jpg' }}" class="volunteer-card-img" alt="Imagen de perfil del voluntario">
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
                    <a href="{{ route('voluntarios.show', ['voluntario' => $voluntario]) }}" class="volunteer-info btn btn-primary">Más información</a>
                    <a href="{{ route('voluntarios.edit', ['voluntario' => $voluntario]) }}" class="volunteer-modify btn btn-primary">Modificar</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>



<!-- Modal -->
<div class="modal fade" id="modal-dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #008080; display: flex; justify-content: center; align-items: center;">
                <h4 class="modal-title" style="color: white; font-weight: bold;">Añadir horas</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <!-- Aquí está el formulario -->
                <form>
                    @csrf
                    <input type="hidden" name="voluntariosSeleccionados" id="voluntariosSeleccionados" value="">

                    <div id="voluntarios-seleccionados"></div>

                    <label for="horas">Horas:</label>
                    <input type="number" name="horas" id="horas" required>

                    <label for="tarea_id">Tarea:</label>
                    <input type="text" id="buscadorTarea" placeholder="Escribe una tarea" autocomplete="off" class="form-control">
                    <input type="hidden" name="tarea_id" id="tareaSeleccionada">
                    <div id="listaTareas" class="lista-sugerencias"></div>
                </form>
            </div>

            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</a>
                <button type="button" class="btn btn-success" id="btn-agregar" onclick="agregarHoras()">Agregar</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal de añadir tarea -->



<div id="tableView" class="table-responsive " style="display: none;">
    <!-- Contenido de la vista de tabla -->
    <div class="table-responsive">
        <table id="data-table-default" width="100%" class="table table-bordered align-middle text-nowrap table-striped">
            <thead style="background-color: #40E0D0;">
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
    let table = $('#data-table-default').DataTable({
        responsive: true,
        select: {
            style: 'multi'
        }
    });

    let voluntariosSeleccionados = [];
    let voluntariosNombres = [];

    $('#data-table-default tbody').off('click').on('click', 'tr', function() {
        let voluntarioId = table.row(this).data()[0];
        let voluntarioNombre = table.row(this).data()[1];
        let voluntarioApellido = table.row(this).data()[2];

        console.log("Voluntario ID:", voluntarioId); // Nuevo console.log
        console.log("Voluntario Nombre:", voluntarioNombre); // Nuevo console.log
        console.log("Voluntario Apellido:", voluntarioApellido); // Nuevo console.log

        let index = voluntariosSeleccionados.indexOf(voluntarioId);

        if (index === -1) {
            voluntariosSeleccionados.push(voluntarioId);
            voluntariosNombres.push(voluntarioNombre + ' ' + voluntarioApellido); // Modifica esta línea
        } else {
            voluntariosSeleccionados.splice(index, 1);
            voluntariosNombres.splice(index, 1);
        }

        console.log("Voluntarios seleccionados:", voluntariosSeleccionados);
        console.log("Voluntarios nombres:", voluntariosNombres);

        $('#modal-dialog .modal-body #voluntarios-seleccionados').empty();

        // Crea una cadena con los nombres separados por comas, pero con 'y' antes del último nombre
        let nombresConcatenados = '';
        if (voluntariosNombres.length > 1) {
            nombresConcatenados = voluntariosNombres.slice(0, -1).map(nombre => `<strong>${nombre}</strong>`).join(', ') + ' y a ' + `<strong>${voluntariosNombres[voluntariosNombres.length - 1]}</strong>.`;
        } else if (voluntariosNombres.length === 1) {
            nombresConcatenados = `<strong>${voluntariosNombres[0]}</strong>`;
        }

        // Agrega la cadena al div en el cuerpo del modal
        $('#modal-dialog .modal-body #voluntarios-seleccionados').append(
            `<p style="font-size: 20px;">Se le <strong>añadirán horas</strong> a ${nombresConcatenados}</p>`);
    });

    function agregarHoras() {
        // Recolecta los voluntarios seleccionados
        let voluntariosSeleccionadosJSON = JSON.stringify(voluntariosSeleccionados);

        // Captura el valor de las horas y tarea_id
        let horas = $('#horas').val();
        let tareaId = $('#tareaSeleccionada').val(); // Asegúrate de que este campo contiene el ID correcto

        console.log("Horas: ", horas);
        console.log("Tarea ID: ", tareaId); // Verifica que se capture el valor correcto
        console.log("Voluntarios seleccionados JSON: ", voluntariosSeleccionadosJSON); // Nuevo console.log

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
                    horas: horas,
                    tarea_id: tareaId // Asegúrate de enviar el ID correcto
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
                    console.error("Error en la solicitud AJAX:", xhr.responseText);
                    // Podrías mostrar un mensaje al usuario también
                    swal({
                        title: 'Error',
                        text: 'Hubo un problema al añadir las horas, por favor revisa los datos.',
                        icon: 'error',
                        button: 'Ok'
                    });
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
        var modeDisplay = document.getElementById('modeDisplay'); // Elemento que muestra el modo actual

        // Asumimos que empezamos en la vista de tarjetas
        var isCardView = true;

        toggleButton.addEventListener('click', function() {
            // Cambia una clase en el cuerpo (u otra lógica que puedas tener) para cambiar la vista
            document.body.classList.toggle('cards-view');

            // Actualiza el texto del modo actual basado en la vista
            modeDisplay.textContent = isCardView ? 'Voluntarios' : 'Voluntarios';

            // Alterna el estado
            isCardView = !isCardView;

            // Alterna la visibilidad de otros botones basados en la vista
            demoButton.style.display = isCardView ? 'none' : 'block'; // Asegura que el botón solo aparezca en la vista de tabla
            botonTarea.style.display = isCardView ? 'none' : 'block';
        });
    });
</script>


<script>
    $(document).ready(function() {
        $("#buscadorTarea").on('input', function() {
            var inputValue = $(this).val();
            if (inputValue.length >= 1) {
                $.ajax({
                    url: "/buscar-tareas",
                    type: "GET",
                    data: {
                        query: inputValue
                    },
                    success: function(data) {
                        var listaTareas = $("#listaTareas");
                        listaTareas.empty();
                        var colorToggle = false; // Variable para alternar colores
                        if (data.length) {
                            data.forEach(function(tarea) {
                                $.ajax({
                                    url: "/tareas/" + tarea.id + "/lugar",
                                    type: "GET",
                                    success: function(lugar) {
                                        var colorClass = colorToggle ? 'opcion-tarea-gris' : 'opcion-tarea-blanco'; // Alternar clase basado en colorToggle
                                        colorToggle = !colorToggle; // Cambiar el estado de colorToggle para la próxima iteración

                                        listaTareas.append(`
                                        <div class='opcion-tarea ${colorClass}' data-id='${tarea.id}' style="margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; padding: 5px;">
    <!-- Contenedor para la tarea y su icono -->
    <div style="display: flex; align-items: center;">
        <svg class='icono-tarea' fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" height="24px">
            <path d="M 10 4 L 10 6 L 4 6 L 4 20 L 20 20 L 20 6 L 14 6 L 14 4 L 10 4 z M 12 4 L 12 6 L 14 6 L 14 4 L 12 4 z M 6 8 L 18 8 L 18 18 L 6 18 L 6 8 z M 8 10 L 8 12 L 10 12 L 10 10 L 8 10 z M 12 10 L 12 12 L 16 12 L 16 10 L 12 10 z M 8 14 L 8 16 L 10 16 L 10 14 L 8 14 z M 12 14 L 12 16 L 16 16 L 16 14 L 12 14 z"/>
        </svg>
        <span class='nombre-tarea'>${tarea.nombre}</span>
    </div>
    <!-- Contenedor para el lugar y su icono -->
    <div style="display: flex; align-items: center;">
        <svg class='icono-lugar' fill="#808080" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" height="24px">
            <path d="M 12 2 C 8.1458516 2 5 5.1458516 5 9 C 5 12.060703 6.5479097 15.446303 10.09375 18.96875 L 12 21 L 13.90625 18.96875 C 17.45209 15.446303 19 12.060703 19 9 C 19 5.1458516 15.854148 2 12 2 z M 12 4 C 14.773268 4 17 6.2267317 17 9 C 17 11.224902 15.777626 13.930926 12.59375 17.03125 L 12 17.71875 L 11.40625 17.03125 C 8.222374 13.930926 7 11.224902 7 9 C 7 6.2267317 9.2267317 4 12 4 z M 12 6 A 2 2 0 0 0 12 10 A 2 2 0 0 0 12 6 z"/>
        </svg>
        <span style="font-style: italic; color: #808080;">${lugar.LUG_nombre}</span>
    </div>
</div>

                                    `);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Error en la solicitud AJAX: " + error);
                                    }
                                });
                            });
                            listaTareas.show();
                        } else {
                            listaTareas.hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la solicitud AJAX: " + error);
                    }
                });
            } else {
                $("#listaTareas").empty().hide();
            }
        });

        $(document).on('click', '.opcion-tarea', function() {
            var tareaNombre = $(this).find('.nombre-tarea').text();
            var tareaId = $(this).data('id');
            $("#buscadorTarea").val(tareaNombre);
            $("#tareaSeleccionada").val(tareaId);
            console.log("Tarea ID seleccionada:", tareaId);
            $("#listaTareas").empty().hide();
        });
    });
</script>
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