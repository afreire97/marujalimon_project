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


    <!-- Tarjetas de voluntarios con nuevo estilo -->
<div id="cardView" class="row row-cols-md-3 row-cols-lg-4 gx-1 mt-5">
    @foreach ($voluntarios as $voluntario)
    <div class="col mb-4">
        <!-- Tarjeta con nuevo estilo -->
        <div class="card h-100 border-0 shadow-sm" data-tilt>
            <!-- Imagen de perfil del voluntario -->
            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Imagen de perfil del voluntario">
            
            <div class="card-body">
                <h5 class="card-title">{{$voluntario->VOL_nombre}}</h5>
                <p class="card-text">DNI: {{$voluntario->VOL_dni}}</p>
                <a href="{{route('voluntarios.show', ['voluntario' => $voluntario])}}" class="btn btn-outline-primary  mb-1">Más información</a>
                <a href="{{route('voluntario.edit_form', ['voluntario' => $voluntario])}}" class="btn btn-outline-primary ">Modificar</a>
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
                        <th width="1%">Nombre</th>
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
                    <tr>
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

<!-- Bootstrap and Additional JS Scripts -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
