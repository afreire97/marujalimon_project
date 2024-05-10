<x-layout>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>




    <div class="mode-container" style="display: flex; align-items: center; justify-content: space-between; background-color: #008080; padding: 10px; border-radius: 5px; width: 100%;">


        <a class="btn btn-success" href="{{ url()->previous() }}">Volver</a>

        <div style="flex-grow: 1; display: flex; justify-content: center;">
            <div id="modeDisplay" style="color: white; font-size: 24px;">Voluntarios</div>
        </div>

        <ul class="nav nav-pills mb-2">
            <li class="nav-item">
                <a href="#nav-pills-tab-1" data-bs-toggle="tab" class="btn btn-info" onclick="changeMode('Voluntarios')">
                    <span class="d-sm-none">Voluntarios</span>
                    <span class="d-sm-block d-none">Voluntarios</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#nav-pills-tab-2" data-bs-toggle="tab" class="btn btn-warning" onclick="changeMode('Coordinadores')">
                    <span class="d-sm-none">Coordinadores</span>
                    <span class="d-sm-block d-none">Coordinadores</span>
                </a>
            </li>
        </ul>
    </div>

        <div class="row d-flex justify-content-center">
            <!-- Columna izquierda -->
            <div class="col-xl-6">
                <!-- Pestañas de navegación -->


                <!-- Contenido de las pestañas -->
                <div class="tab-content p-3 rounded-top panel rounded-0 m-0">
                    <!-- Contenido de la pestaña de Voluntarios -->
                    <div class="tab-pane fade active show" id="nav-pills-tab-1">

                        <div id="tableView" class="table-responsive" style="display: block">
                            <!-- Tabla de voluntarios -->
                            <table id="data-table-default" width="100%"
                                class="table table-bordered align-middle text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Último registro</th>
                                        <th>Info</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Iteración sobre los voluntarios -->
                                    @foreach ($voluntarios as $voluntario)
                                        <tr>
                                            <td>{{ $voluntario->VOL_nombre }}</td>
                                            <td>{{ $voluntario->VOL_apellidos }}</td>
                                            <td>{{ $voluntario->horas()->latest()->first()->created_at }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-success"
                                                    href="{{ route('voluntarios.show', ['voluntario' => $voluntario]) }}">Más
                                                    información</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- Contenido de la pestaña de Coordinadores -->
                    <div class="tab-pane fade" id="nav-pills-tab-2">
                        <div class="card-body">
                            <div id="tableView" class="table-responsive" style="display: block">
                                <!-- Tabla de coordinadores -->
                                <table id="data-table-defaultC" width="100%"
                                    class="table table-bordered align-middle text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Apellidos</th>
                                            <th>Fecha de asignación</th>
                                            <th>Info</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Iteración sobre los coordinadores -->
                                        @foreach ($coordinadores as $coordinador)
                                            <tr>
                                                <td>{{ $coordinador->COO_nombre }}</td>
                                                <td>{{ $coordinador->COO_apellidos }}</td>
                                                <td>{{ $fechasAsociacion[$coordinador->COO_id] }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('coordinadores.show', ['coordinadore' => $coordinador]) }}">Más
                                                        información</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <script src="{{ asset('tabla/assets/plugins/datatables.net-select/js/dataTables.select.min.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('tabla/assets/plugins/datatables.net/js/dataTables.min.js') }}"></script>
        <script src="{{ asset('tabla/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}">
        </script>
        <script>
            let table = $('#data-table-default').DataTable({
                responsive: true,
                select: true,

            });
        </script>
        <script>
            let tablec = $('#data-table-defaultC').DataTable({
                responsive: true,
                select: true,

            });
        </script>

        <script src="{{ asset('tabla/assets/plugins/datatables.net-select/js/dataTables.select.min.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="{{ asset('tabla/assets/plugins/datatables.net/js/dataTables.min.js') }}"></script>
        <script src="{{ asset('tabla/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}">
        </script>
        <script>
            let table = $('#data-table-default').DataTable({
                responsive: true,
                select: true,

            });
        </script>

@include('scripts.info_personal_js')


</x-layout>
