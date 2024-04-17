<x-layout>

    <p>Voluntario: {{$voluntario->VOL_nombre}}</p>

    <form action="{{ route('calcularHoras', ['voluntario' => $voluntario]) }}" method="post">
        @csrf

        <fieldset>
            <legend>Introduce el período de tiempo para calcular las horas realizadas</legend>

            <div class="row mb-3">
                <label for="fecha_inicio" class="col-sm-2 col-form-label">Fecha de inicio</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                </div>
            </div>

            <a href="">sdasde</a>
            <div class="row mb-3">
                <label for="fecha_fin" class="col-sm-2 col-form-label">Fecha de fin</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Calcular horas</button>
        </fieldset>
    </form>

    @if(isset($totalHoras))
        <p>Total de horas realizadas: {{$totalHoras}}</p>
    @endif

</x-layout>


{{-- https://www.chartjs.org/docs/latest/samples/bar/vertical.html --}}
