<?php
// En la parte superior de tu archivo PHP, antes de usarla
function randomScalingFactor()
{
    return mt_rand(0, 100);
}
?>


<x-layout>
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
                    <h1 class="display-4 font-weight-bold text" id="welcomeMessage" style="padding-top:30px;">
                        ¡Te damos la bienvenida, {{ ucfirst(strtolower(Auth::user()->name)) }}!
                    </h1>
                    <p class="lead mb-0 text-secondary" id="dynamicText"></p>
                    @if (Auth::check())
                    <div class="typewriter" style="padding-bottom:30px;">
                        <p id="fixedColorText">Explora lo que nuestro sistema tiene para ofrecer y comienza tu
                            jornada.</p>

                    </div>
                    @endif
                </div>
            </div>
            @endauth
        </div>
    </header>




    <!-- Sección de tarjetas con efecto de inclinación -->
    <div class="container-fluid mt-5 mb-5">
        <div class="row g-4 justify-content-center">
            <!-- Ajusta el ancho de las columnas a col-md-4 col-lg-3 para más espacio -->
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div id="form-container">
                    <form id="year-form">
                        <label for="year">
                            <p></p>
                            <h5 class="card-title text-custom-primary">Seleccione un año <i class="fa fa-calendar-alt"></i></h5>
                            <p></p>
                            <p class="card-text" style="font-weight: normal;">Seleccione un año en concreto para desplegar el gráfico proporcionando así datos relevantes.</p> <!-- Aquí está el cambio -->
                            <p></p>
                        </label>
                        <p></p>
                        <select name="year" id="year">
                            @for ($i = date('Y'); $i >= 2010; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <p></p>
                        <button type="submit" class="btn btn-lg" style="background-color: #13abbf; color: white;">Desplegar gráfico</button>
                    </form>
                </div>
            </div>

            <!-- Tarjeta de Listar Voluntarios -->

            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card h-100 border-0 shadow-sm" data-tilt>
                    <div class="card-body">
                        <h5 class="card-title text-custom-primary">Listar Voluntarios <i class="fa fa-users"></i></h5>
                        <p class="card-text">Accede a la lista de voluntarios y gestiona su toda información.</p>
                        <a href="{{ route('voluntarios.index') }}" class="btn custom-btn btn-lg rounded-pill">Ver Voluntarios</a>
                        <p></p>
                        <a href="{{ route('voluntarios.create') }}" class="btn custom-btn btn-lg rounded-pill">Añadir Voluntario</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Listar Coordinadores -->
            @if (auth()->check() && auth()->user()->is_admin)
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card h-100 border-0 shadow-sm" data-tilt>
                    <div class="card-body">
                        <h5 class="card-title text-custom-primary">Listar Coordinadores <i class="fa fa-user-tie"></i></h5>
                        <p class="card-text">Accede a la lista de coordinadores y gestiona su información.</p>
                        <a href="{{ route('coordinadores.index') }}" class="btn custom-btn btn-lg rounded-pill">Ver Coordinadores</a>
                        <p></p>
                        <a href="{{ route('coordinadores.create') }}" class="btn custom-btn btn-lg rounded-pill">Añadir Coordinador</a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Tarjeta de Listar Lugares -->
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card h-100 border-0 shadow-sm" data-tilt>
                    <div class="card-body">
                        <h5 class="card-title text-custom-primary">Listar Lugares <i class="fa fa-map-marker-alt"></i></h5>
                        <p class="card-text">Accede a la lista de lugares y gestiona toda su información disponible.</p>
                        <a href="{{ route('lugares.index') }}" class="btn custom-btn btn-lg rounded-pill">Ver Lugares</a>
                        <p></p>
                        <a href="{{ route('lugares.create') }}" class="btn custom-btn btn-lg rounded-pill">Añadir Lugar</a>
                    </div>
                </div>
            </div>


            <!-- Tarjeta de Registro -->
            <div class="col-sm-6 col-md-4 col-lg-2">
    <div class="card h-100 border-0 shadow-sm" data-tilt>
        <div class="card-body">
            <h5 class="card-title text-custom-primary">Registro <i class="fas fa-file-alt"></i></h5>
            <div class="d-flex flex-column align-items-stretch">
                <p></p>
                <a href="{{ route('voluntarios.create') }}" class="btn btn-custom btn-lg rounded-pill mb-2">Registrar voluntario</a>
                @if (auth()->check() && auth()->user()->is_admin)
                <p></p>
                <a href="{{ route('coordinadores.create') }}" class="btn btn-custom btn-lg rounded-pill mb-2">Registrar coordinador</a>
                <p></p>
                <a href="{{ route('register') }}" class="btn btn-custom btn-lg rounded-pill">Registrar admin</a>
                @endif
            </div>
        </div>
    </div>
</div>
        </div>
    </div>







    @include('components.line-chart', [])



    @include('scripts.welcomeJs');


</x-layout>
