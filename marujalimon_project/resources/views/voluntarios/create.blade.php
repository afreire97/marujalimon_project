<x-layout>

    <head>
        <link href="{{ asset('css/estilos_voluntario_form.css') }}" rel="stylesheet">

    </head>
    <div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header text-white text-center">
            <h3>Registrar Voluntario</h3>
        </div>
        <!-- Mensajes de éxito -->
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

    </div>
    <form action="{{ route('voluntarios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Directiva Blade para el token CSRF -->

        <div class="card-body">
            <!-- Campos del formulario -->
            @foreach ($fields as $name => $label)
                @if ($name === 'DEL_id' && !$delegaciones->isEmpty())
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">Delegación</label>
                        <div class="col-md-6">
                            <select name="DEL_id" class="form-select">
                                <option value="" selected disabled>Selecciona una delegación</option>
                                @foreach ($delegaciones as $delegacion)
                                    <option value="{{ $delegacion->id }}">{{ $delegacion->DEL_nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @elseif ($name === 'COO_id' && !$coordinadores->isEmpty())
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">Coordinador</label>
                        <div class="col-md-6">
                            <select name="COO_id" class="form-select">
                                <option value="" selected disabled>Selecciona un coordinador</option>
                                @foreach ($coordinadores as $coordinador)
                                    <option value="{{ $coordinador->id }}">{{ $coordinador->COO_nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @elseif ($name === 'VOL_dias_semana_dispo')
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">{{ $label }}</label>
                        <div class="col-md-6">
                            <select name="VOL_dias_semana_dispo[]" class="form-select" multiple>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sábado">Sábado</option>
                                <option value="Domingo">Domingo</option>
                            </select>
                    </div>
                @elseif ($name === 'VOL_carnet' || $name === 'VOL_seguro' || $name === 'VOL_autoriza_datos' || $name === 'VOL_autoriza_imagen' || $name === 'VOL_curso')
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">{{ $label }}</label>
                        <div class="col-md-6">
                            <input type="checkbox" name="{{ $name }}" value="1">
                        </div>
                    </div>
                @elseif ($name === 'password2' || $name === 'password')
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">{{ $label }}</label>
                        <div class="col-md-6">
                            <input type="password" name="{{ $name }}" class="form-control">
                        </div>
                    </div>
                @else
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">
                            {{ $label }} @if ($name !== 'VOL_tel' && $name !== 'VOL_cp' && $name !== 'VOL_sexo' && $name !== 'imagen_perfil' && $name !== 'VOL_dias_semana_dispo') <span class="text-danger">*</span> @endif
                        </label>
                        <div class="col-md-6">
                            @if ($name === 'VOL_fecha_nac' || $name === 'VOL_fecha_inicio')
                                <input type="date" name="{{ $name }}" class="form-control" value="{{ old($name) }}">
                            @elseif ($name === 'VOL_tel' || $name === 'VOL_cp')
                                <input type="text" name="{{ $name }}" class="form-control" value="{{ old($name) }}">
                            @elseif ($name === 'VOL_sexo')
                                <select name="{{ $name }}" class="form-select">
                                    <option value="Mujer">Mujer</option>
                                    <option value="Hombre">Hombre</option>
                                    <option value="">Otro</option>
                                </select>
                            @elseif ($name === 'imagen_perfil')
                                <input type="file" name="{{ $name }}" class="form-control-file" >
                            @else
                                <input type="text" name="{{ $name }}" class="form-control" @if ($name !== 'VOL_tel' && $name !== 'VOL_cp' && $name !== 'VOL_sexo') required @endif value="{{ old($name) }}">
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Botón de envío -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>



    <script>
        // Aquí tu código JavaScript
        document.addEventListener("DOMContentLoaded", function() {
            var themeItems = document.querySelectorAll('.theme-list-item a');
            var cardHeader = document.querySelector('.card-header'); // Selecciona el card-header

            themeItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    var themeColor = this.getAttribute('data-theme-color'); // Suponiendo que cada enlace tiene un data-theme-color
                    cardHeader.style.backgroundColor = themeColor; // Aplica el color directamente al card header
                });
            });
        });
    </script>

</x-layout>
