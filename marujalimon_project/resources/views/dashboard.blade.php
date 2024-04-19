<x-app-layout>

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
</x-app-layout>

<!-- Bootstrap and Additional JS Scripts -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
<!-- Tilt.js for Card Effect -->
<script src="https://cdn.jsdelivr.net/npm/tilt.js"></script>
<!-- Typed.js for Typing Animation -->
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<!-- FontAwesome for Icons -->
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>

<script>
    // Initialize Typing Animation for Welcome Message
    new Typed('#welcomeMessage', {
        strings: ["¡Bienvenido, {{ Auth::user()->name }}!"],
        typeSpeed: 50,
        loop: false
    });
</script>
