<?php
// En la parte superior de tu archivo PHP, antes de usarla
function randomScalingFactor() {
    return mt_rand(0, 100);
}
?>


<x-layout>
    <header class="bg-light py-5 mb-4">
        <div class="container h-100">
            @auth
                <div class="row h-100 align-items-center">
                    <div class="col-lg-12 text-center">
                        <h1 class="display-4 text-primary font-weight-bold" id="welcomeMessage"></h1>
                        <p class="lead mb-0 text-secondary">Explora lo que nuestro sistema tiene para ofrecer y comienza tu jornada.</p>
                    </div>
                </div>
            @endauth
        </div>
    </header>

    <!-- Sección de tarjetas con efecto de inclinación -->
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- Tarjeta con efecto de inclinación para listar voluntarios -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm" data-tilt>
                    <div class="card-body">
                        <h5 class="card-title text-primary">Listar Voluntarios <i class="fa fa-users"></i></h5>
                        <p class="card-text">Accede a la lista de voluntarios y gestiona su información.</p>
                        <a href="{{ route('voluntarios.index') }}" class="btn btn-outline-primary stretched-link">Ver Voluntarios</a>
                    </div>
                </div>
            </div>
            <!-- Más tarjetas para otras funciones -->
        </div>
    </div>
    @include('components.line-chart', [
        'chartId' => 'line-chart',
        'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        'dataset1Label' => 'Dataset 1',
        'dataset1Data' => [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
        'dataset2Label' => 'Dataset 2',
        'dataset2Data' => [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
    ])

</x-layout>
