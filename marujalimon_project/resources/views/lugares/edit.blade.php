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
                    <label for="LUG_provincia" class="col-md-4 col-form-label text-md-end">Provincia <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="LUG_provincia" id="LUG_provincia" class="form-control" value="{{ $lugar->LUG_provincia }}" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="LUG_localidad" class="col-md-4 col-form-label text-md-end">Localidad <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="LUG_localidad" id="LUG_localidad" class="form-control" value="{{ $lugar->LUG_localidad }}" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="LUG_delegacion" class="col-md-4 col-form-label text-md-end">Delegación <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="LUG_delegacion" id="LUG_delegacion" class="form-control" value="{{ $lugar->LUG_delegacion }}" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="LUG_cp" class="col-md-4 col-form-label text-md-end">CP<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="LUG_cp" id="LUG_cp" class="form-control" value="{{ $lugar->LUG_cp }}" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="LUG_url_maps" class="col-md-4 col-form-label text-md-end">URL de Google Maps <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="LUG_url_maps" id="LUG_url_maps" class="form-control" value="{{ $lugar->LUG_url_maps }}" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="IMG_path" class="col-md-4 col-form-label text-md-end">Imagen <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="file" name="IMG_path" id="IMG_path" class="form-control" required>
                    </div>
                </div>

        </div>
    </form>
</x-layout>
