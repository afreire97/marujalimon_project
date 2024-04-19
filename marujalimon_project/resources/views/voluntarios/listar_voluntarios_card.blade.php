<x-layout>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


    <link href="{{ asset('css/blog/card.list.css') }}" rel="stylesheet" />

{{-- <a href="{{route('listarVoluntariosTabla')}}">Cambiar vista</a> --}}

<div class="d-grid gap-2 mb-3">
    <button id="toggleViewButton" class="btn btn-primary">Cambiar Vista</button>
</div>


<div id="cardView" class="row row-cols-md-3 row-cols-lg-4 gx-1 mt-5">

        @foreach ($voluntarios as $voluntario)
            <div class="col mb-4"> <!-- Cambiado de col a col-auto -->
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

<div id="tableView" class="table-responsive " style="display: none;">
    <!-- Contenido de la vista de tabla -->
    <div class="table-responsive">
        <table id="data-table-default" width="100%" class="table table-bordered align-middle text-nowrap">
            <thead>
                <tr>
                    <th width="1%">ID</th>
                    <th width="1%" >Nombre</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Domicilio</th>
                    <th>Código Postal</th>
                    <th>Teléfono</th>
                    <th>Sexo</th>
                    <th>Correo Electrónico</th>
                </tr>
            </thead>
            <tbody>
                @foreach($voluntarios as $voluntario)
                <tr >
                    <td>{{ $voluntario->VOL_id }}</td>
                    <td>{{ $voluntario->VOL_nombre }}</td>
                    <td>{{ $voluntario->VOL_apellidos }}</td>
                    <td>{{ $voluntario->VOL_dni }}</td>
                    <td>{{ $voluntario->VOL_fecha_nac }}</td>
                    <td>{{ $voluntario->VOL_domicilio }}</td>
                    <td>{{ $voluntario->VOL_cp }}</td>
                    <td>{{ $voluntario->VOL_tel1 }}</td>
                    <td>{{ $voluntario->VOL_sexo }}</td>
                    <td>{{ $voluntario->VOL_mail }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>












<div class="paginacion">
    {{ $voluntarios->links() }}

</div>





</x-layout>
