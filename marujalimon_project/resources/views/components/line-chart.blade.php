@push('scripts')
<script src="{{ asset('/tabla/assets/plugins/chart.umd.js') }}"></script>
<script src="{{ asset('/js/graficos/chart-js.demo.js') }}"></script>
<script src="{{ asset('/js/graficos/highlight.min.js') }}"></script>
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

<!-- Agrega aquí tus enlaces a scripts y otras dependencias -->
<script src="{{ asset('/tabla/assets/plugins/chart.umd.js') }}"></script>
<script src="{{ asset('/js/graficos/chart-js.demo.js') }}"></script>
<script src="{{ asset('/js/graficos/highlight.min.js') }}"></script>
<script src="{{ asset('/js/graficos/render.highlight.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const ctx = document.getElementById('line-chart').getContext('2d');
        let lineChart;

        const yearForm = document.getElementById('year-form');
        const yearSelect = document.getElementById('year');

        // Función para cargar los datos del gráfico
        async function cargarDatos(year) {
            try {
                const response = await fetch(`{{ route('totalHorasVoluntarios') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        year: year
                    })
                });

                if (!response.ok) {
                    throw new Error('Error al obtener los datos de horas por mes');
                }

                const data = await response.json();

                // Limpiar el gráfico existente si existe
                if (lineChart) {
                    lineChart.destroy();
                }

                // Configurar el nuevo gráfico de líneas
                lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: Object.keys(data.totalHorasPorMes),
                        datasets: [{
                            label: `Horas totales voluntarios (${year})`,
                            borderColor: 'rgba(0, 0, 255, 1)',
                            pointBackgroundColor: 'rgba(0, 0, 255, 1)',
                            pointRadius: 4,
                            borderWidth: 2,
                            backgroundColor: 'rgba(0, 0, 255, .3)',
                            data: Object.values(data.totalHorasPorMes)
                        }]
                    }
                });
            } catch (error) {
                console.error('Error al obtener los datos de horas por mes:', error);
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
