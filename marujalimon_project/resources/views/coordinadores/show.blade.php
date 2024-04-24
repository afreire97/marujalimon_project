<x-layout>

    <!-- En la parte superior de tu archivo blade -->
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

    <div class="col-md-8" style="position: relative;"> <!-- Añade posición relativa aquí -->
        <div class="card-body">
            <h3 class="card-title">{{ $coordinador->COO_nombre }} {{ $coordinador->COO_apellidos }}</h3>
            <div class="mb-3">
                <i class="bi bi-person-fill me-2"></i><strong>DNI:</strong> {{ $coordinador->COO_dni }}
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
                {{ $coordinador->COO_cp }}
            </div>
            <div class="mb-3">
                <i class="bi bi-telephone-fill me-2"></i><strong>Teléfono:</strong>
                {{ $coordinador->COO_tel1 }}
            </div>
            <div class="mb-3">
                <i class="bi bi-gender-ambiguous me-2"></i><strong>Género:</strong>
                {{ $coordinador->COO_sexo }}
            </div>
            <div class="mb-3">
                <i class="bi bi-envelope-fill me-2"></i><strong>Correo Electrónico:</strong>
                {{ $coordinador->COO_mail }}
            </div>
        </div>
    </div>

</x-layout>
