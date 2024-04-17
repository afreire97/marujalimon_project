<x-layout>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        <div class="container my-5">
            <div class="card mx-auto border-0 shadow-lg animate__animated animate__fadeIn" style="max-width: 940px;">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="my-0">Volunteer Information</h2>
                </div>
                <div class="row g-0">
                    <div class="col-md-4 d-flex align-items-center p-3">
                        @if ($voluntario->imagenPerfil && $voluntario->imagenPerfil->IMG_path)
                            <img src="{{ asset($voluntario->imagenPerfil->IMG_path) }}" class="img-fluid"
                                style="max-height: 250px; max-width: 100%; border-radius: 5px;" alt="Imagen de perfil">
                        @endif
                        asdfs

                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title">{{ $voluntario->VOL_nombre }} {{ $voluntario->VOL_apellidos }}</h3>
                            <div class="mb-3">
                                <i class="bi bi-person-fill me-2"></i><strong>DNI:</strong> {{ $voluntario->VOL_dni }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-calendar3 me-2"></i><strong>Birthdate:</strong>
                                {{ $voluntario->VOL_fecha_nac }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-geo-alt-fill me-2"></i><strong>Address:</strong>
                                {{ $voluntario->VOL_domicilio }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-geo-alt-fill me-2"></i><strong>Postal Code:</strong>
                                {{ $voluntario->VOL_cp }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-telephone-fill me-2"></i><strong>Phone:</strong>
                                {{ $voluntario->VOL_tel1 }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-gender-ambiguous me-2"></i><strong>Gender:</strong>
                                {{ $voluntario->VOL_sexo }}
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-envelope-fill me-2"></i><strong>Email:</strong>
                                {{ $voluntario->VOL_mail }}
                            </div>
                        </div>
                        <div class="card-footer text-muted text-center w-100">

                            <a href="{{ route('voluntario.edit_form', ['voluntario' => $voluntario]) }}"
                                class="btn btn-primary">Edit Profile</a>
                            <form action="{{ route('voluntario.destroy', ['voluntario' => $voluntario]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Profile</button>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-12 px-4 py-2">
                                <canvas id="hoursChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // Espera a que la página se cargue completamente
                    document.addEventListener('DOMContentLoaded', function() {
                        var ctx = document.getElementById('hoursChart').getContext('2d');
                        var hoursChart = new Chart(ctx, {
                            type: 'bar', // O el tipo de gráfico que prefieras: 'line', 'pie', etc.
                            data: {
                                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Marzo',
                                ''], // Aquí irían los meses o las categorías
                                datasets: [{
                                    label: 'Horas Voluntariado',
                                    data: [12, 19, 3, 5], // Aquí irían los datos de las horas
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Colores de fondo
                                    borderColor: 'rgba(54, 162, 235, 1)', // Colores de borde
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
                </script>
</x-layout>
