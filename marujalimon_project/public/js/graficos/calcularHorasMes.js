

document.getElementById('calcularHorasForm').addEventListener('submit', function(event) {
    // Evitar el envío del formulario
    event.preventDefault();

    // Obtener el año del formulario
    var ano = document.getElementById('ano').value;

    // Enviar una solicitud AJAX al servidor para obtener los datos de horas por mes

    var ruta = document.getElementById('ruta').getAttribute('data-route');

    fetch(ruta, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ano: ano
            })
        })
        .then(response => response.json())
        .then(data => {
            // Mostrar el contenedor del gráfico
            document.getElementById('chartContainer').style.display = 'block';

            // Obtener el contexto del lienzo para el gráfico mensual
            var monthlyCtx = document.getElementById('monthlyChart').getContext('2d');

            // Destruir el gráfico anterior si existe
            if (window.monthlyChart && typeof window.monthlyChart.destroy === 'function') {
                window.monthlyChart.destroy();
            }

            // Configurar el gráfico mensual
            window.monthlyChart = new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
                        'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    datasets: [{
                        label: 'Horas Voluntariado (' + ano + ')',
                        data: Object.values(data.horasPorMes),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error al obtener los datos de horas por mes:', error);
        });
});
