<x-layout>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



        <div class="container my-5">
            <div class="card mx-auto border-0 shadow-lg animate__animated animate__fadeIn" style="max-width: 1940px;">
                <div class="card-header text-white text-center">
                    <h2 class="my-0">Información del voluntario</h2>
                </div>
                <div class="row g-0">
                    <div class="col-md-4 p-3">
                        <div
                            style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            @if ($voluntario->imagenPerfil && $voluntario->imagenPerfil->IMG_path)
                                <!-- Asegúrate de que la imagen ocupe hasta el máximo ancho disponible sin ser estirada -->
                                <img src="{{ asset($voluntario->imagenPerfil->IMG_path) }}" class="img-fluid"
                                    style="border-radius: 5px; max-width: 100%; height: auto;" alt="Imagen de perfil">
                            @endif
                        </div>
                        <!-- Un div separado para el botón, fuera del div de la imagen -->
                        <div style="text-align: center; padding-top: 10px;">
                            <!-- Agrega un poco de espacio entre la imagen y el botón -->
                            <a href="{{ route('voluntario.edit_form', ['voluntario' => $voluntario]) }}"
                                class="btn btn-primary">Editar Perfil</a>
                        </div>
                    </div>
                    <div class="col-md-8" style="position: relative;"> <!-- Añade posición relativa aquí -->
                        <div class="card-body">
                            <h3 class="card-title">{{ $voluntario->VOL_nombre }} {{ $voluntario->VOL_apellidos }}</h3>
                            <div class="mb-3">
                                <i class="bi bi-person-fill me-2"></i><strong>DNI:</strong> {{ $voluntario->VOL_dni }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-calendar3 me-2"></i><strong>Fecha de nacimiento:</strong>
                                {{ date('d-m-Y', strtotime($voluntario->VOL_fecha_nac)) }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-geo-alt-fill me-2"></i><strong>Dirección:</strong>
                                {{ $voluntario->VOL_domicilio }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-geo-alt-fill me-2"></i><strong>Código Postal:</strong>
                                {{ $voluntario->VOL_cp }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-telephone-fill me-2"></i><strong>Teléfono:</strong>
                                {{ $voluntario->VOL_tel1 }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-gender-ambiguous me-2"></i><strong>Género:</strong>
                                {{ $voluntario->VOL_sexo }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-envelope-fill me-2"></i><strong>Correo Electrónico:</strong>
                                {{ $voluntario->VOL_mail }}
                            </div>
                            <hr class="my-4">
                            <!-- Puedes usar un separador para distinguir claramente las secciones -->
                            <form action="{{ route('calcularHoras', ['voluntario' => $voluntario]) }}" method="post">
                                @csrf

                                <fieldset>
                                    <legend>Introduce el período de tiempo para calcular las horas realizadas</legend>

                                    <div class="row mb-3">
                                        <label for="fecha_inicio" class="col-sm-2 col-form-label">Fecha de
                                            inicio</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="fecha_inicio"
                                                name="fecha_inicio">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fecha_fin" class="col-sm-2 col-form-label">Fecha de fin</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Calcular horas</button>
                                </fieldset>
                            </form>

                            @if (isset($totalHoras))
                                <p>Total de horas realizadas: {{ $totalHoras }}</p>
                            @endif

                            <form action="{{ route('mostrarHorasPorMes', ['voluntario' => $voluntario]) }}"
                                method="POST" id="calcularHorasForm" data-voluntario="{{$voluntario}}>
                                @csrf
                                <div class="row mb-3">
                                    <label for="ano" class="col-md-4 col-form-label">Año:</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="ano" name="ano"
                                            required>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Calcular horas por mes</button>
                                </div>
                            </form>


                        </div> <!-- Fin del div card-body -->
                        <div style="position: absolute; top: 0; right: 0; padding: 10px;">
                            <form id="deleteForm"
                                action="{{ route('voluntario.destroy', ['voluntario' => $voluntario]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Eliminar
                                    Perfil</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">

                </div>
                {{-- <div class="row">
                    <div class="col-12 px-4 py-2">
                        <canvas id="monthlyChart" style="display: block;"></canvas>
                        <canvas id="weeklyChart" style="display: none;"></canvas>
                    </div>
                </div> --}}
                <div class="row" id="chartContainer" style="display: none;">
                    <div class="col-12 px-4 py-2">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                <div class="card-footer text-muted text-center w-100">
                    <!-- ... otros botones ... -->
                    <button id="toggleChart" class="btn btn-secondary">Ver datos semanales</button>
                </div>
            </div>




            <script>
                document.getElementById('calcularHorasForm').addEventListener('submit', function(event) {
                    // Evitar el envío del formulario
                    event.preventDefault();

                    // Obtener el año del formulario
                    var ano = document.getElementById('ano').value;

                    // Enviar una solicitud AJAX al servidor para obtener los datos de horas por mes
                    fetch('{{ route('mostrarHorasPorMes', ['voluntario' => $voluntario]) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                ano: ano
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Mostrar el contenedor del gráfico
                            document.getElementById('chartContainer').style.display = 'block';

                            // Obtener el contexto del lienzo para el gráfico mensual
                            var monthlyCtx = document.getElementById('monthlyChart').getContext('2d');

                            // Destruir el gráfico anterior si existe
                            if (window.monthlyChart && typeof window.monthlyChart.destroy === 'function') {
                                window.monthlyChart.destroy();
                            }

                            // Configurar el gráfico mensual
                            window.monthlyChart = new Chart(monthlyCtx, {
                                type: 'bar',
                                data: {
                                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
                                        'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                                    ],
                                    datasets: [{
                                        label: 'Horas Voluntariado (' + ano + ')',
                                        data: Object.values(data.horasPorMes),
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error al obtener los datos de horas por mes:', error);
                        });
                });
            </script>


            <script>
                function confirmDelete() {
                    Swal.fire({
                        title: '¿Estás seguro de que deseas eliminar a este voluntario?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: '¡Sí, eliminar!',
                        cancelButtonText: 'Cancelar',
                        focusCancel: true, // Foco en el botón de cancelar
                        customClass: {
                            confirmButton: 'swal-confirm-btn',
                            cancelButton: 'swal-cancel-btn'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                '¡Eliminado!',
                                'El voluntario ha sido eliminado.',
                                'success'
                            ).then(() => {
                                // Enviar el formulario después de mostrar el mensaje de éxito
                                document.getElementById('deleteForm').submit();
                            });
                        }
                    })
                }
            </script>

            <!-- Agrega esto en la sección de tus scripts si aún no tienes jQuery -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <script>
                $(document).ready(function() {
                    // Cuando se envía el formulario para calcular horas
                    $('form#calculoHorasForm').on('submit', function(e) {
                        e.preventDefault(); // Previene el envío normal del formulario

                        var form = $(this);
                        var url = form.attr('action');

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: form.serialize(), // Serializa los datos del formulario
                            success: function(data) {
                                // Actualiza la información de las horas en la página
                                $('#totalHorasDiv').text("Total de horas realizadas: " + data
                                    .totalHoras);
                            }
                        });
                    });
                });
            </script>




</x-layout>
