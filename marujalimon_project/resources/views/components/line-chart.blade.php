@push('scripts')
    <script src="{{ asset('/tabla/assets/plugins/chart.umd.js') }}"></script>

    <script src="{{ asset('/js/graficos/render.highlight.js') }}"></script>
@endpush

<div>
    <form id="year-form">
        <label for="year">Seleccione el año:</label>
        <select name="year" id="year">
            @for ($i = date('Y'); $i >= 2010; $i--)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
        <button type="submit">Enviar</button>
    </form>
</div>

<div>
    <canvas id="line-chart"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const ctx = document.getElementById('line-chart').getContext('2d');
        let lineChart;

        const yearForm = document.getElementById('year-form');
        const yearSelect = document.getElementById('year');
        Chart.defaults.color = 'rgba(' + app.color.componentColorRgb + ', .65)';
        Chart.defaults.font.family = app.font.family;
        Chart.defaults.font.weight = 500;
        Chart.defaults.scale.grid.color = 'rgba(' + app.color.componentColorRgb + ', .15)';
        Chart.defaults.scale.ticks.backdropColor = 'rgba(' + app.color.componentColorRgb + ', .160)';

        // Función para cargar los datos del gráfico
        async function cargarDatos(year) {
            try {
                const horasResponse = await fetch(`{{ route('totalHorasVoluntarios') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        year: year
                    })
                });

                const tareasResponse = await fetch(`{{ route('totalTareasPorMes') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        year: year
                    })
                });

                if (!horasResponse.ok || !tareasResponse.ok) {
                    throw new Error('Error al obtener los datos');
                }

                const horasData = await horasResponse.json();
                const tareasData = await tareasResponse.json();

                // Limpiar el gráfico existente si existe
                if (lineChart) {
                    lineChart.destroy();
                }

                // Configurar el nuevo gráfico de líneas
                lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: Object.keys(horasData.totalHorasPorMes),
                        datasets: [{
                            label: `Horas totales voluntarios (${year})`,
                            borderColor: 'rgba(0, 0, 255, 1)',
                            pointBackgroundColor: 'rgba(0, 0, 255, 1)',
                            pointRadius: 4,
                            borderWidth: 2,
                            backgroundColor: 'rgba(0, 0, 255, .3)',
                            data: Object.values(horasData.totalHorasPorMes)
                        }, {
                            label: `Total de tareas (${year})`,
                            borderColor: 'rgba(255, 0, 0, 1)',
                            pointBackgroundColor: 'rgba(255, 0, 0, 1)',
                            pointRadius: 4,
                            borderWidth: 2,
                            backgroundColor: 'rgba(255, 0, 0, .3)',
                            data: Object.values(tareasData.totalTareasPorMes)
                        }]
                    }
                });
            } catch (error) {
                console.error('Error al obtener los datos:', error);
            }
        }

        // Manejar el envío del formulario
        yearForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const selectedYear = yearSelect.value;
            cargarDatos(selectedYear);
        });

        // Cargar los datos para el año actual al cargar la página
        const currentYear = new Date().getFullYear();
        cargarDatos(currentYear);
    });
</script>
