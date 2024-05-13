<x-layout>



@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('voluntarios.update', ['voluntario' => $voluntario]) }}" method="POST" enctype="multipart/form-data">
    @csrf <!-- Directiva Blade para el token CSRF -->
    @method('PUT')
    <div class="card-body">
        <!-- Campos del formulario -->
        @foreach ($fields as $name => $label)

            @if ($name === 'VOL_dias_semana_dispo')
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
                </div>
            @elseif ($name === 'VOL_carnet' || $name === 'VOL_seguro' || $name === 'VOL_autoriza_datos' || $name === 'VOL_autoriza_imagen' || $name === 'VOL_curso')
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label text-md-end">{{ $label }}</label>
                    <div class="col-md-6">
                        <input type="checkbox" name="{{ $name }}" value="1" @if($voluntario->{$name} == 1) checked @endif>
                    </div>
                </div>
            @elseif ($name === 'password2' || $name === 'password')

            @else
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label text-md-end">
                        {{ $label }} @if ($name !== 'VOL_tel' && $name !== 'VOL_cp' && $name !== 'VOL_sexo' && $name !== 'imagen_perfil' && $name !== 'VOL_dias_semana_dispo') <span class="text-danger">*</span> @endif
                    </label>
                    <div class="col-md-6">
                        @if ($name === 'VOL_fecha_nac' || $name === 'VOL_fecha_inicio')
                            <input type="date" name="{{ $name }}" class="form-control" value="{{ $voluntario->{$name} }}">
                        @elseif ($name === 'VOL_tel' || $name === 'VOL_cp')
                            <input type="text" name="{{ $name }}" class="form-control" value="{{ $voluntario->{$name} }}">
                        @elseif ($name === 'VOL_sexo')
                            <select name="{{ $name }}" class="form-select">
                                <option value="Mujer" @if($voluntario->{$name} == 'Mujer') selected @endif>Mujer</option>
                                <option value="Hombre" @if($voluntario->{$name} == 'Hombre') selected @endif>Hombre</option>
                                <option value="" @if($voluntario->{$name} == '') selected @endif>Otro</option>
                            </select>
                        @elseif ($name === 'imagen_perfil')
                            <input type="file" name="{{ $name }}" class="form-control-file">
                        @else
                            <input type="text" name="{{ $name }}" class="form-control" @if ($name !== 'VOL_tel' && $name !== 'VOL_cp' && $name !== 'VOL_sexo') required @endif value="{{ $voluntario->{$name} }}">
                        @endif
                    </div>
                </div>
            @endif
        @endforeach


        @if (!$coordinadores->isEmpty())
        <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end">Coordinador</label>
            <div class="col-md-6">
                <select name="COO_id" class="form-select">
                    <option value="" selected disabled>Selecciona un coordinador</option>
                    @foreach ($coordinadores as $coordinador)
                        <option value="{{ $coordinador->COO_id }}">{{ $coordinador->COO_nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @endif
        <!-- Botón de envío -->
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>

</x-layout>
