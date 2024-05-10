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

    <form action="{{ route('coordinadores.update', ['coordinadore' => $coordinador]) }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Directiva Blade para el token CSRF -->
        @method('PUT')
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
                                    <option value="{{ $delegacion->DEL_id }}">{{ $delegacion->DEL_nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                @elseif ($name === 'COO_dias_semana_dispo')
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">{{ $label }}</label>
                        <div class="col-md-6">
                            <select name="COO_dias_semana_dispo[]" class="form-select" multiple>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sábado">Sábado</option>
                                <option value="Domingo">Domingo</option>
                            </select>
                        </div>
                    </div>
                @elseif ($name === 'COO_carnet' || $name === 'COO_seguro' || $name === 'COO_autoriza_datos' || $name === 'COO_autoriza_imagen' || $name === 'COO_curso')
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">{{ $label }}</label>
                        <div class="col-md-6">
                            <input type="checkbox" name="{{ $name }}" value="1" @if($coordinador->{$name} == 1) checked @endif>
                        </div>
                    </div>
                @elseif ($name === 'password2' || $name === 'password')

                @else
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">
                            {{ $label }} @if ($name !== 'COO_tel' && $name !== 'COO_cp' && $name !== 'COO_sexo' && $name !== 'imagen_perfil' && $name !== 'COO_dias_semana_dispo') <span class="text-danger">*</span> @endif
                        </label>
                        <div class="col-md-6">
                            @if ($name === 'COO_fecha_nac' || $name === 'COO_fecha_inicio')
                                <input type="date" name="{{ $name }}" class="form-control" value="{{ $coordinador->{$name} }}">
                            @elseif ($name === 'COO_tel' || $name === 'COO_cp')
                                <input type="text" name="{{ $name }}" class="form-control" value="{{ $coordinador->{$name} }}">
                            @elseif ($name === 'COO_sexo')
                                <select name="{{ $name }}" class="form-select">
                                    <option value="Mujer" @if($coordinador->{$name} == 'Mujer') selected @endif>Mujer</option>
                                    <option value="Hombre" @if($coordinador->{$name} == 'Hombre') selected @endif>Hombre</option>
                                    <option value="" @if($coordinador->{$name} == '') selected @endif>Otro</option>
                                </select>
                            @elseif ($name === 'imagen_perfil')
                                <input type="file" name="{{ $name }}" class="form-control-file">
                            @else
                                <input type="text" name="{{ $name }}" class="form-control" @if ($name !== 'COO_tel' && $name !== 'COO_cp' && $name !== 'COO_sexo') required @endif value="{{ $coordinador->{$name} }}">
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


</x-layout>
