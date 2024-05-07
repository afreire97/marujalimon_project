<x-layout>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <div class="container">
        <h1>Voluntarios Asociados al Lugar: {{ $lugar->LUG_nombre }}</h1>


        <br>



        <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link active">Tab 1</a>
            </li>
          </ul>
          <div class="tab-content panel p-3 rounded-0 rounded-bottom">
            <div class="tab-pane fade active show" id="default-tab-1">
              ...
            </div>
          </div>

        <div class="card">
            <h2>Voluntarios</h2>
            <div class="card-body">



                <div id="tableView" class="table-responsive " style="display: block">
                    <!-- Contenido de la vista de tabla -->
                    <div class="table-responsive">
                        <table id="data-table-default" width="100%" class="table table-bordered align-middle text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Último registro</th>
                                    <th>Info</th>
                                    <!-- Agrega más columnas si necesitas mostrar más detalles del voluntario -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($voluntarios as $voluntario)
                                    <tr>
                                        <td>{{ $voluntario->VOL_nombre }}</td>
                                        <td>{{ $voluntario->VOL_apellidos }}</td>
                                        <td>{{ $voluntario->horas()->latest()->first()->created_at }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-success"
                                                href="{{ route('voluntarios.show', ['voluntario' => $voluntario]) }}">
                                                Más información</a>

                                        </td>
                                        <!-- Agrega más columnas si necesitas mostrar más detalles del voluntario -->
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>
                    </div>
                </div>

            </div>
        </div>

        <div class="card">
            <h2>Coordinadores</h2>
            <div class="card-body">

                <div id="tableView" class="table-responsive " style="display: block">
                    <!-- Contenido de la vista de tabla -->
                    <div class="table-responsive">
                        <table id="data-table-default" width="100%" class="table table-bordered align-middle text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>

                                    <th>Fecha de asignación</th>
                                    <th>Info</th>
                                    <!-- Agrega más columnas si necesitas mostrar más detalles del voluntario -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coordinadores as $coordinador)
                                    <tr>
                                        <td>{{ $coordinador->COO_nombre}}</td>
                                        <td>{{ $coordinador->COO_apellidos }}</td>
                                        <td>{{ $fechasAsociacion[$coordinador->COO_id] }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-success"
                                                href="{{ route('voluntarios.show', ['voluntario' => $voluntario]) }}">
                                                Más información</a>
                                        </td>
                                        <!-- Agrega más columnas si necesitas mostrar más detalles del voluntario -->
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>
                    </div>
                </div>

            </div>
        </div>






    <script src="{{ asset('tabla/assets/plugins/datatables.net-select/js/dataTables.select.min.js') }}"></script>
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script>
        let table = $('#data-table-default').DataTable({
            responsive: true,
            select: true,

        });
    </script>
</x-layout>
