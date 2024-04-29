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
    if (!sessionStorage.getItem('firstVisit')) {
        console.log("First visit detected, delaying chart creation...");
        sessionStorage.setItem('firstVisit', 'true');
        console.log("sessionStorage set after creating chart:", sessionStorage.getItem('firstVisit'));
        setTimeout(initializeChart, 7000); // Delay of 7 seconds
    } else {
        console.log("Not the first visit, creating chart immediately...");
        initializeChart();
    }
});

async function initializeChart() {
    console.log("sessionStorage state on load:", sessionStorage.getItem('firstVisit'));

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
        console.log("Loading data for year:", year);

        const horasResponse = await fetch(`{{ route('totalHorasVoluntarios') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ year: year })
        });

        const tareasResponse = await fetch(`{{ route('totalTareasPorMes') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ year: year })
        });

        if (!horasResponse.ok || !tareasResponse.ok) {
            throw new Error('Error retrieving data');
        }

        const horasData = await horasResponse.json();
        const tareasData = await tareasResponse.json();

        const horasPorMes = Object.values(horasData.totalHorasPorMes);
        const tareasPorMes = Object.values(tareasData.totalTareasPorMes);
        const labels = Object.keys(horasData.totalHorasPorMes);

        function createChart() {
            console.log("Creating chart...");
            if (lineChart) {
                lineChart.data.labels = labels;
                lineChart.data.datasets[0].data = horasPorMes;
                lineChart.data.datasets[1].data = tareasPorMes;
                lineChart.update();
            } else {
                lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: `Horas totales voluntarios (${year})`,
                            borderColor: 'rgba(0, 0, 255, 1)',
                            pointBackgroundColor: 'rgba(0, 0, 255, 1)',
                            pointRadius: 4,
                            borderWidth: 2,
                            backgroundColor: 'rgba(0, 0, 255, .3)',
                            data: horasPorMes
                        }, {
                            label: `Total de tareas (${year})`,
                            borderColor: 'rgba(255, 0, 0, 1)',
                            pointBackgroundColor: 'rgba(255, 0, 0, 1)',
                            pointRadius: 4,
                            borderWidth: 2,
                            backgroundColor: 'rgba(255, 0, 0, .3)',
                            data: tareasPorMes
                        }]
                    },
                    options: {
                        animation: {
                            duration: 1500 // duration in milliseconds
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
            }
            const chartContainer = document.getElementById('chart-container');
            chartContainer.style.opacity = "1";
        }

        createChart();
    }

    const currentYear = new Date().getFullYear();
    await cargarDatos(currentYear);

    yearForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        const selectedYear = yearSelect.value;
        await cargarDatos(selectedYear);
    });
}
</script>



