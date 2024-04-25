<?php
// En la parte superior de tu archivo PHP, antes de usarla
function randomScalingFactor()
{
    return mt_rand(0, 100);
}
?>


<x-layout><br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
<header class="bg-lava-lamp py-5 mb-4 header">
    <div class="container-fluid h-100">
            @auth
            <div class="rhombus-container left-rhombuses">
                <div class="rhombus"></div>
                <div class="rhombus"></div>
                <div class="rhombus"></div>
            </div>
            <div class="rhombus-container right-rhombuses">
                <div class="rhombus"></div>
                <div class="rhombus"></div>
                <div class="rhombus"></div>
            </div>

            <div class="row h-100 align-items-center header-content">
            <div class="col-lg-12 text-center bg-light-gray">
                    <h1 class="display-4 font-weight-bold text-primary" id="welcomeMessage"  style="padding-top:30px;">
                        ¡Te damos la bienvenida, {{ ucfirst(strtolower(Auth::user()->name)) }}!
                    </h1>
                    <p class="lead mb-0 text-secondary" id="dynamicText"></p>
                    @if(Auth::check())
                    <div class="typewriter" style="padding-bottom:30px;">
        <p>Explora lo que nuestro sistema tiene para ofrecer y comienza tu jornada.</p>
                </div>
                    @endif
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
            @if(auth()->check() && auth()->user()->is_admin)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm" data-tilt>
                    <div class="card-body">
                        <h5 class="card-title text-primary">Listar Coordinadores <i class="fa fa-users"></i></h5>
                        <p class="card-text">Accede a la lista de coordinadores y gestiona su información.</p>
                        <a href="{{ route('coordinadores.index') }}" class="btn btn-outline-primary stretched-link">Ver Coordinadores</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>



    @include('components.line-chart', [

    ])

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Animación inicial para el mensaje de bienvenida
            welcomeMessage.style.opacity = 0;
            window.requestAnimationFrame(function() {
                welcomeMessage.style.transition = 'opacity 8s';
                welcomeMessage.style.opacity = 1;
            });
        });
    </script>

</x-layout>
