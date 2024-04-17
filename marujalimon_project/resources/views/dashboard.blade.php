<x-app-layout>

    <div class="py-12">
        <div class="bg-white dark:bg-gray-800">
            <div class="bg-white dark:bg-gray-800 overflow-hidden  sm:rounded-lg">
                <div class="bg-white dark:bg-gray-800">
                    @auth
                        Bienvenido: {{ Auth::user()->name }}
                    @endauth
                </div>

            </div>
        </div>

    </div>
<a class="btn btn-primary mt-4 " href="{{route('voluntarios.index')}}">Listar voluntarios</a>


</x-app-layout>
