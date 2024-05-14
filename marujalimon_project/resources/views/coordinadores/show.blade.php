<x-layout>

    <!-- En la parte superior de tu archivo blade -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Mensajes de error de validación -->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <div class="container my-5">
        <div class="card mx-auto border-0 shadow-lg animate__animated animate__fadeIn" style="max-width: 1940px;">
            <div class="card-header text-white text-center">
                <h2 class="my-0">Información del coordinador</h2>
            </div>
            <div class="row g-0">
                <div class="col-md-4 p-3">
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        @if ($coordinador->imagenPerfil && $coordinador->imagenPerfil->IMG_path)
                            <!-- Imagen de perfil existente -->
                            <img src="{{ asset($coordinador->imagenPerfil->IMG_path) }}" class="img-fluid"
                                style="border-radius: 5px; max-width: 100%; height: auto;" alt="Imagen de perfil">
                        @else
                            <!-- Imagen placeholder de perfil -->
                            <img src="{{ $coordinador->imagenPerfil ? $coordinador->imagenPerfil->IMG_path : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 448 512\'%3E%3Cpath fill=\'%23999\' d=\'M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.4-46.6 16-72.9 16s-50.7-5.6-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z\'/%3E%3C/svg%3E' }}"
                                class="card-img-top" alt="Imagen de perfil del voluntario">
                        @endif
                    </div>
                    <div style="text-align: left; padding-top: 10px;">
                        <a href="{{ route('coordinadores.edit', ['coordinadore' => $coordinador]) }}"
                            class="btn btn-primary d-block w-100">Editar Perfil</a>
                    </div>

                </div>



                <div class="col-md-8" style="position: relative;"> <!-- Añade posición relativa aquí -->
                    <div class="card-body">
                        <h3 class="card-title">{{ $coordinador->COO_nombre }} {{ $coordinador->COO_apellidos }}</h3>



                        <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <i class="bi bi-person-fill me-2"></i><strong>DNI:</strong> {{ $coordinador->COO_apellidos }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-calendar3 me-2"></i><strong>Fecha de nacimiento:</strong>
                                        {{ date('d-m-Y', strtotime($coordinador->COO_fecha_nac)) }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-geo-alt-fill me-2"></i><strong>Dirección:</strong>
                                        {{ $coordinador->COO_domicilio }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-geo-alt-fill me-2"></i><strong>Código Postal:</strong>
                                        {{ $coordinador->COO_cp}}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-telephone-fill me-2"></i><strong>Teléfono:</strong>
                                        {{ $coordinador->COO_tel }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-gender-ambiguous me-2"></i><strong>Género:</strong>
                                        {{ $coordinador->COO_sexo }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-envelope-fill me-2"></i><strong>Correo Electrónico:</strong>
                                        {{ $coordinador->COO_mail }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-card-text me-2"></i><strong>Trabajo Actual:</strong>
                                        {{ $coordinador->COO_trabajo_actual }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <i class="bi bi-calendar3 me-2"></i><strong>Fecha de Inicio:</strong>
                                        {{ date('d-m-Y', strtotime($coordinador->COO_fecha_inicio)) }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-heart-fill me-2"></i><strong>Preferencia:</strong>
                                        {{ $coordinador->COO_preferencia }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-calendar3 me-2"></i><strong>Días de la Semana Disponibles:</strong>
                                        {{ $coordinador->COO_dias_semana_dispo }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-check2-circle me-2"></i><strong>Carnet:</strong>
                                        {{ $coordinador->COO_carnet ? 'Sí' : 'No' }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-shield-fill-check me-2"></i><strong>Seguro:</strong>
                                        {{ $coordinador->COO_seguro ? 'Sí' : 'No' }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-book-half me-2"></i><strong>Curso:</strong>
                                        {{ $coordinador->COO_curso ? 'Sí' : 'No' }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-check2-circle me-2"></i><strong>Autoriza Datos:</strong>
                                        {{ $coordinador->COO_autoriza_datos ? 'Sí' : 'No' }}
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-check2-circle me-2"></i><strong>Autoriza Imagen:</strong>
                                        {{ $coordinador->COO_autoriza_imagen ? 'Sí' : 'No' }}
                                    </div>
                                </div>
                            </div>
                        <hr class="my-4">
                        <!-- Puedes usar un separador para distinguir claramente las secciones -->

                        @if (!$lugares->isEmpty())
                        <div class="mb-3">
                            <i class="bi bi-geo-alt-fill me-2"></i><strong>Lugares asignados:</strong>

                            @foreach ($lugares as $lugar)
                            <p>{{$lugar->LUG_nombre}}</p>
                            @endforeach


                        </div>

                        @endif
                    </div> <!-- Fin del div card-body -->
                    <div style="position: absolute; top: 0; right: 0; padding: 10px;">
                        <form id="deleteForm"
                            action="{{ route('coordinadores.destroy', ['coordinadore' => $coordinador]) }}"
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


        </div>
    </div>

    <div class="row row-cols-4">
        @foreach ($voluntarios as $voluntario)
            <div class="col card border-0 shadow-sm">
                <a href="#">
                    @if ($voluntario->imagenPerfil)
                        <img src="{{$voluntario->imagenPerfil->IMG_path}}" class="img-fluid" alt="Imagen de perfil del voluntario">
                    @else
                        <img src="https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1095249842.jpg" class="img-fluid" alt="Avatar placeholder">
                    @endif
                </a>
                <div class="volunteer-card-body">
                    <h5 class="volunteer-card-title"><i class="fas fa-user"></i>{{$voluntario->VOL_nombre . " " . $voluntario->VOL_apellidos}}</h5>
                    <p class="volunteer-card-text text-truncate"><i class="fas fa-id-card"></i>DNI: {{$voluntario->VOL_dni}}</p>
                    <div class="volunteer-card-buttons">
                        <a href="/voluntarios/{{$voluntario->VOL_id}}" class="volunteer-info btn btn-primary">Más información</a>
                        <a href="/voluntarios/{{$voluntario->VOL_id}}/edit" class="volunteer-modify btn btn-primary">Modificar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>



   </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/delete/delete.js') }}"></script>



</x-layout>
