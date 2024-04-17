<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden  sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @auth
                        Bienvenido: {{ Auth::user()->name }}
                    @endauth
                </div>

            </div>
        </div>

    </div>
<a class="btn btn-primary mt-4 " href="{{route('voluntarios.index')}}">Listar voluntarios</a>

</x-app-layout>
