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
    <form action="{{ route('voluntarios.update', ['voluntario' => $voluntario]) }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Directiva Blade para el token CSRF -->
        @method('PUT')
        <div class="card-body">
            <!-- Campos del formulario -->
            @foreach ($fields as $name => $label)
                @if ($name === 'DEL_id' && !$delegaciones->isEmpty())
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">
                            Delegación
                        </label>
                        <div class="col-md-6">
                            <select name="DEL_id" class="form-select">
                                <option value="" selected disabled>Selecciona una delegación</option>
                                @foreach ($delegaciones as $delegacion)
                                    <option value="{{ $delegacion->DEL_id }}">{{ $delegacion->DEL_nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @elseif ($name === 'COO_id' && !$coordinadores->isEmpty())
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">
                            Coordinador
                        </label>
                        <div class="col-md-6">
                            <select name="COO_id" class="form-select">
                                <option value="" selected disabled>Selecciona un coordinador</option>
                                @foreach ($coordinadores as $coordinador)
                                    <option value="{{ $coordinador->COO_id }}">{{ $coordinador->COO_nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">
                            {{ $label }} @if ($name !== 'VOL_tel1' && $name !== 'VOL_cp' && $name !== 'VOL_sexo' && $name !== 'VOL_demandas' && $name !== 'VOL_fecha_baja' && $name !== 'VOL_col_pref' && $name !== 'VOL_carnet' && $name !== 'VOL_seguro' && $name !== 'VOL_seguro_exento' && $name !== 'VOL_cdns' && $name !== 'VOL_cdns_pdf' && $name !== 'VOL_curso' && $name !== 'VOL_tiene_usuario' && $name !== 'VOL_demandas' && $name !== 'VOL_autoriza_datos' && $name !== 'VOL_lugar_voluntariado' && $name !== 'VOL_dias_semana_dispo' && $name !== 'VOL_dispo_dot' && $name !== 'VOL_dispo_cubierta' && $name !== 'VOL_autoriza_uso_imagen' && $name !== 'VOL_autoriza_uso_imagen_cubierto' && $name !== 'VOL_for_for_inicial' && $name !== 'VOL_for_mayores' && $name !== 'VOL_for_menores' && $name !== 'VOL_for_discapacidad' && $name !== 'VOL_for_otras') <span class="text-danger">*</span> @endif
                        </label>
                        <div class="col-md-6">
                            @if (array_key_exists($name, $selectFields))
                                <select name="{{ $name }}" class="form-select">
                                    <option value="" selected disabled>Selecciona una opción</option>
                                    @foreach ($selectFields[$name] as $option)
                                        <option value="{{ $option }}" @if ($option === $voluntario->$name) selected @endif>{{ $option }}</option>
                                    @endforeach
                                </select>
                            @elseif ($name === 'VOL_fecha_nac' || $name === 'VOL_fecha_baja')
                                <input type="date" name="{{ $name }}" class="form-control" value="{{ $voluntario->$name }}">
                            @elseif ($name === 'VOL_tel1')
                                <input type="tel" name="{{ $name }}" class="form-control" pattern="[0-9]{9}" value="{{ $voluntario->$name }}">
                            @elseif ($name === 'VOL_cp')
                                <input type="text" name="{{ $name }}" class="form-control" pattern="[0-9]{5}" maxlength="5" value="{{ $voluntario->$name }}">
                            @elseif ($name === 'VOL_demandas' || $name === 'VOL_col_pref' || $name === 'VOL_carnet' || $name === 'VOL_seguro' || $name === 'VOL_seguro_exento' || $name === 'VOL_cdns' || $name === 'VOL_cdns_pdf' || $name === 'VOL_curso' || $name === 'VOL_lugar_voluntariado' || $name === 'VOL_dias_semana_dispo')
                                <input type="text" name="{{ $name }}" class="form-control" value="{{ $voluntario->$name }}">
                            @elseif ($name === 'VOL_tiene_usuario' || $name === 'VOL_autoriza_datos' || $name === 'VOL_dispo_dot' || $name === 'VOL_dispo_cubierta' || $name === 'VOL_autoriza_uso_imagen' || $name === 'VOL_autoriza_uso_imagen_cubierto' || $name === 'VOL_for_for_inicial' || $name === 'VOL_for_mayores' || $name === 'VOL_for_menores' || $name === 'VOL_for_discapacidad' || $name === 'VOL_for_otras')
                                <input type="checkbox" name="{{ $name }}" class="form-check-input" @if ($voluntario->$name) checked @endif>
                            @else
                                <input type="text" name="{{ $name }}" class="form-control" @if ($name !== 'VOL_tel1' && $name !== 'VOL_cp' && $name !== 'VOL_sexo' && $name !== 'VOL_demandas') required @endif value="{{ $voluntario->$name }}">
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Campo para la imagen de perfil -->
            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end">
                    Imagen de Perfil <span class="text-danger">*</span>
                </label>
                <div class="col-md-6">
                    <input type="file" name="imagen_perfil" class="form-control" accept="image/*" required>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
    </form>
</x-layout>
