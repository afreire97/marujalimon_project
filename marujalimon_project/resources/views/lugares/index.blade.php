<x-layout>
    <div id="cardView" class="row mt-5">
        @foreach ($lugares as $lugar)
            <div class="col col-custom mb-4">
                <div class="card h-100 border-0 shadow-sm card-lugar">

                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-map-marker-alt"></i> {{ $lugar->LUG_nombre }}
                        </h5>
                        <p class="card-text">
                            <!-- Aquí puedes mostrar cualquier otra información relevante del lugar -->
                        </p>
                        <div class="place-card-buttons d-flex justify-content-center mt-3">
                            <a href="{{ route('lugares.show', ['lugar' => $lugar]) }}"
                               class="place-info btn btn-primary">Más información</a>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>
