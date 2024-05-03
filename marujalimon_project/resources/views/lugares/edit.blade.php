<x-layout>
    <form method="POST" action="{{ route('lugares.update', ['lugar' => $lugar]) }}" class="container mt-5 mb-5" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Agregar este campo para indicar que es una solicitud de actualización -->

        <div class="card shadow">
            <div class="card-header text-white text-center">
                <h3>Editar Lugar</h3>
            </div>
            <!-- Mensajes de éxito -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- Campos del formulario con valores prellenados -->
            <div class="card-body">
                <div class="mb-3 row">
                    <label for="LUG_nombre" class="col-md-4 col-form-label text-md-end">Nombre <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="LUG_nombre" id="LUG_nombre" class="form-control" value="{{ $lugar->LUG_nombre }}" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="LUG_direccion" class="col-md-4 col-form-label text-md-end">Dirección <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="LUG_direccion" id="LUG_direccion" class="form-control" value="{{ $lugar->LUG_direccion }}" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="IMG_path" class="col-md-4 col-form-label text-md-end">Imagen <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="file" name="IMG_path" id="IMG_path" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Botones del formulario -->
            <div class="card-footer text-end">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </div>
    </form>
</x-layout>
