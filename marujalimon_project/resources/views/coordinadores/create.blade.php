<x-layout>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('coordinadores.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header text-white text-center">
            <h3>Registrar Coordinador</h3>
        </div>
        <!-- Mensajes de éxito y de error -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('coordinador.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                <!-- Campos del formulario -->
                @foreach ($fields as $name => $label)
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label text-md-end">
                        {{ $label }} @if ($name !== 'COO_tel1' && $name !== 'COO_cp' && $name !== 'COO_sexo') <span class="text-danger">*</span> @endif
                    </label>
                    <div class="col-md-6">
                        @if ($name === 'COO_fecha_nac')
                            <input type="date" name="{{ $name }}" class="form-control" required>
                        @elseif ($name === 'COO_tel1')
                            <input type="text" name="{{ $name }}" class="form-control">
                        @elseif ($name === 'COO_cp')
                            <input type="text" name="{{ $name }}" class="form-control" pattern="[0-9]{5}" maxlength="5">
                        @elseif ($name === 'COO_sexo')
                            <select name="{{ $name }}" class="form-select">
                                @foreach ($selectFields[$name] as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" name="{{ $name }}" class="form-control" required>
                        @endif
                    </div>
                </div>
                @endforeach

                <!-- Campo para seleccionar la delegación -->
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label text-md-end">Delegación</label>
                    <div class="col-md-6">
                        <select name="delegacion_id" class="form-select" required>
                            <option value="" selected disabled>Selecciona una delegación</option>
                            @foreach ($delegaciones as $delegacion)
                                <option value="{{ $delegacion->DEL_id }}">{{ $delegacion->DEL_nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Campo para la imagen de perfil -->
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label text-md-end">Imagen de Perfil <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="file" name="imagen_perfil" class="form-control" accept="image/*" required>
                    </div>
                </div>

                <!-- Campos para contraseña -->
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label text-md-end">Contraseña<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="password" class="form-control fs-13px" placeholder="Contraseña" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label text-md-end">Confirmar Contraseña <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="password" class="form-control fs-13px" placeholder="Confirmar Contraseña" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>
    </div>
</div>

    </form>

</x-layout>
