@push('scripts')
    <script src="{{ asset('/tabla/assets/plugins/chart.umd.js') }}"></script>

    <script src="{{ asset('/js/graficos/render.highlight.js') }}"></script>
@endpush




<div id="chart-container" class="hidden">
    <canvas id="line-chart"></canvas>
</div>


<!-- Dentro de tu vista Blade -->
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
        Chart.defaults.scale.ticks.backdropColor = 'rgba(' + app.color.componentColorRgb + ', 0)';

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

                if (lineChart) {
                    lineChart.destroy();
                }

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
                    },
                    options: {
                        animation: {
                            duration: 1500 // duración en milisegundos
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#767676'
                                },
                                grid: {
                                    color: '#e0e0e0'
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#767676'
                                },
                                grid: {
                                    color: '#e0e0e0'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#767676'
                                }
                            }
                        }
                    }
                });

                // Delay the opacity change
                setTimeout(function() {
                    const chartContainer = document.getElementById('chart-container');
                    chartContainer.style.opacity = "1";
                }, 7000); // delay of 7 seconds

            } catch (error) {
                console.error('Error al obtener los datos:', error);
            }
        }

        // Load the initial data
        const currentYear = new Date().getFullYear();
        await cargarDatos(currentYear);

        yearForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            const selectedYear = yearSelect.value;
            await cargarDatos(selectedYear);
        });
    });
</script>