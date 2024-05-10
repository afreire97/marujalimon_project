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

                            @if($voluntario && $voluntario->imagenPerfil)
                            <img src="{{ $voluntario->imagenPerfil->IMG_path }}" class="card-img-top" alt="Imagen de perfil del voluntario">
                        @else
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'%3E%3Cpath fill='%23999' d='M224 256c70.7 0 128-57.3'" class="card-img-top" alt="Imagen de perfil del voluntario">
                        @endif

                        </div>
                        <div style="text-align: left; padding-top: 10px;">
                            <a href="{{ route('voluntario_logeado.edit', ['voluntario' => $voluntario]) }}
                                "
                                class="btn btn-primary d-block w-100">Editar Perfil</a>
                        </div>
                        <div style="text-align: left; padding-top: 10px;">
                            <a href="{{ route('voluntario_logeado.calendario', ['voluntario' => $voluntario]) }}"
                                class="btn btn-primary d-block w-100">Ver calendario</a>
                        </div>
                    </div>


                    <div class="col-md-8" style="position: relative;"> <!-- Añade posición relativa aquí -->
                        <div class="card-body">
                            <h3 class="card-title">{{ $voluntario->VOL_nombre }} {{ $voluntario->VOL_apellidos }}</h3>
                            <div class="mb-3">
                                <i class="bi bi-person-fill me-2"></i><strong>DNI:</strong> {{ $voluntario->VOL_dni }}
                            </div>

                            @foreach ($voluntario->observaciones as $observacion)
                                <p>{{ $observacion->OBS_contenido }}</p>
                            @endforeach







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


                            @if (isset($totalHoras))
                                <p>Total de horas realizadas: {{ $totalHoras }}</p>
                            @endif

                            <hr class="my-4">

                            <legend style="font-size: 20px;">Introduce un año para mostrar un gráfico de horas</legend>




                            <form action="{{ route('mostrarHorasPorMes', ['voluntario' => $voluntario]) }}"
                                method="POST" id="calcularHorasForm" data-voluntario="{{ $voluntario }}">
                                @csrf
                                <div class="row mb-3 gx-2">
                                    <label for="ano" class="col-md-3 col-form-label">Año:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="ano" name="ano"
                                            required>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Calcular horas por mes</button>
                                </div>
                            </form>




                            <div class="row" id="chartContainer" style="display: none;">
                                <div class="col-12 px-4 py-2">
                                    <canvas id="monthlyChart"></canvas>
                                </div>
                            </div>


                        </div> <!-- Fin del div card-body -->
                        <div style="position: absolute; top: 0; right: 0; padding: 10px;">
                            <form id="deleteForm"
                                action="{{ route('voluntario_logeado.destroy', ['voluntario' => $voluntario]) }}"
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



            @include('scripts.voluntario_logeado')



</x-layout>
