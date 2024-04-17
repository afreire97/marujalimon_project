<x-layout>
    <link href="{{ asset('tabla/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('tabla/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>


    <!-- html -->
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
                <tr class="{{ $voluntario->tareas()->count() > 0 ? 'table-success' : 'table-warning' }}">
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

    <script>
        $('#data-table-default').DataTable({
          responsive: true
        });
      </script>
</x-layout>
