<x-app-layout>
    <!-- Mensaje de bienvenida -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @auth
                <h1 class="text-center text-4xl font-semibold text-gray-800">Bienvenido, {{ Auth::user()->name }}</h1>
            @endauth
            <div class="mt-6 text-center text-gray-600">
                <p>Explora lo que nuestro sistema tiene para ofrecer y comienza tu jornada.</p>
            </div>
        </div>
    </div>

    <!-- Contenedor Principal -->
    <div class="flex justify-center">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-8">
            
            <!-- Tarjeta para listar voluntarios -->
            <div class="transform transition duration-500 hover:scale-105">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-lg font-medium">Listar Voluntarios</h2>
                        <p class="text-sm text-gray-500">Accede a la lista de voluntarios y gestiona su información.</p>
                        <div class="mt-4">
                            <a href="{{ route('voluntarios.index') }}" class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-blue-500 rounded shadow ripple hover:shadow-lg focus:outline-none">Ver Voluntarios</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Otras tarjetas -->
            <!-- Repetir la estructura de arriba para otras secciones del sistema -->
        </div>
    </div>
</x-app-layout>
