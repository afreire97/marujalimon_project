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

            <form action="{{ route('storeVoluntario') }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- Directiva Blade para el token CSRF -->
                <div class="card-body">
                    <!-- Campos del formulario -->
                    @php
                    $fields = [
                    'VOL_nombre' => 'Nombre',
                    'VOL_apellidos' => 'Apellidos',
                    'VOL_dni' => 'DNI',
                    'VOL_fecha_nac' => 'Fecha de Nacimiento',
                    'VOL_domicilio' => 'Domicilio',
                    'VOL_cp' => 'Código Postal',
                    'VOL_tel1' => 'Teléfono',
                    'VOL_sexo' => 'Sexo',
                    'VOL_mail' => 'Correo Electrónico'
                    ];
                    $selectFields = [
                    'VOL_sexo' => ['Masculino', 'Femenino', 'Otro']
                    ];
                    @endphp

                    @foreach ($fields as $name => $label)
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">
                            {{ $label }} <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6">
                            @if (array_key_exists($name, $selectFields))
                            <select name="{{ $name }}" class="form-select" required>
                                <option value="" selected disabled>Selecciona una opción</option>
                                @foreach ($selectFields[$name] as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @elseif($name == 'VOL_fecha_nac')
                            <input type="date" name="{{ $name }}" class="form-control" required>
                            @else
                            <input type="text" name="{{ $name }}" class="form-control" required>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <!-- Nuevo campo para la imagen de perfil -->
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">
                            Imagen de Perfil <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6">
                            <input type="file" name="imagen_perfil" class="form-control" accept="image/*" required>
                        </div>
                    </div>

                    <!-- Nuevo campo para Delegación -->
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">
                            Delegación <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6">
                            <select name="DEL_id" class="form-select" required>
                                <option value="" selected disabled>Selecciona una delegación</option>
                                @foreach ($delegaciones as $delegacion)
                                    <option value="{{ $delegacion->DEL_id }}">{{ $delegacion->DEL_nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Nuevo campo para Coordinador -->
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">
                            Coordinador <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6">
                            <select name="COO_id" class="form-select" required>
                                <option value="" selected disabled>Selecciona un coordinador</option>
                                @foreach ($coordinadores as $coordinador)
                                    <option value="{{ $coordinador->COO_id }}">{{ $coordinador->COO_nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                        <label class="mb-2 col-md-4 col-form-label text-md-end" for="password">Password <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="password" class="form-control fs-13px" placeholder="Password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="mb-2 col-md-4 col-form-label text-md-end" for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="password" class="form-control fs-13px" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                    </div>


                </div>
                <div class="card-footer text-end">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
        <!-- Políticas de envío o información adicional -->
        <!-- <div class="shipping-policy mt-4">
            <h5>Política de Envío</h5>
            <ul>
                <li>La firma puede ser requerida para la entrega.</li>
                <li>No enviamos a apartados de correos.</li>
            </ul>
        </div> -->
    </div>
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
