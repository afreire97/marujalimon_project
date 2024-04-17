<x-layout>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


    <link href="{{ asset('css/blog/card.list.css') }}" rel="stylesheet" />

<a href="{{route('listarVoluntariosTabla')}}">Cambiar vista</a>

    <div class="row row-cols-md-3 row-cols-lg-4 gx-1 mt-5">
        @foreach ($voluntarios as $voluntario)
            <div class="col-auto mb-4"> <!-- Cambiado de col a col-auto -->
                <div class="card" style="width: 18rem;">

                    @if ($voluntario->imagenPerfil)
                    <!-- Mostrar la imagen de perfil si está presente -->
                    <img src="{{ asset($voluntario->imagenPerfil->IMG_path) }}" alt="Imagen de perfil">
                @else
                    <!-- Mostrar una imagen predeterminada si no hay imagen de perfil -->
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRRT12i8xBOCNHzNhu6PHQb5nrRnpV1wtUnW0sOMqF6TA&s" alt="Imagen predeterminada">
                @endif



                    <div class="card-body">
                        <h5 class="card-title">{{$voluntario->VOL_nombre}}</h5>
                        <p class="card-text">DNI: {{$voluntario->VOL_dni}}</p>
                        <a href="{{route('voluntarios.show', ['voluntario' => $voluntario])}}" class="btn btn-primary mb-1">Más información</a>
                        <a href="{{route('voluntario.edit_form', ['voluntario' => $voluntario])}}" class="btn btn-primary">Modificar</a>
                        <!-- Agrega cualquier otro enlace o contenido aquí -->
                    </div>
                </div>
            </div>
        @endforeach
    </div>



<div class="paginacion">
    {{ $voluntarios->links() }}

</div>





</x-layout>
