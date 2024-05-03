<x-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Tarjetas de lugares con nuevo estilo -->
<div id="cardView" class="row mt-5">
    @foreach ($lugares as $lugar)
        <div class="col col-custom mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <!-- Start of clickable image -->
                <a href="{{ route('lugares.show', ['lugar' => $lugar]) }}">
                    <img src="{{ $lugar->imagen ? $lugar->imagen->IMG_path : asset("img/default_img/3342177.png") }}"
                        class="volunteer-card-img" alt="Imagen de perfil del voluntario">
                </a>
                <!-- End of clickable image -->

                <div class="volunteer-card-body">
                    <h5 class="volunteer-card-title">
                        <i class="fas fa-user"></i> {{ $lugar->LUG_nombre }}
                    </h5>
                    <p class="volunteer-card-text">
                        <i class="fas fa-id-card"></i> Dirección: {{ $lugar->LUG_direccion }}
                    </p>
                    <div class="volunteer-card-buttons">
                        <a href="{{ route('lugares.show', ['lugar' => $lugar]) }}"
                            class="volunteer-info btn btn-primary">Más información</a>
                        <a href="{{ route('lugares.edit', ['lugar' => $lugar]) }}"
                            class="volunteer-modify btn btn-primary">Modificar</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>


</x-layout>
