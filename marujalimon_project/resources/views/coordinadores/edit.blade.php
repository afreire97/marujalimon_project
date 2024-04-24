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

    <form action="{{ route('coordinadores.update', ['coordinador' => $coordinador]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <!-- Campos del formulario -->
            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end">
                    Nombre <span class="text-danger">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" name="COO_nombre" class="form-control" value="{{ $coordinador->COO_nombre }}" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end">
                    Apellidos
                </label>
                <div class="col-md-6">
                    <input type="text" name="COO_apellidos" class="form-control" value="{{ $coordinador->COO_apellidos }}">
                </div>
            </div>
            <!-- Otros campos -->
            <!-- ... -->
        </div>
        <div class="card-footer text-end">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>

</x-layout>
