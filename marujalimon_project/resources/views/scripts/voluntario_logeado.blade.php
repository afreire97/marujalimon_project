<script>
    document.getElementById('calcularHorasForm').addEventListener('submit', function(event) {
        // Evitar el envío del formulario
        event.preventDefault();

        // Obtener el año del formulario
        var ano = document.getElementById('ano').value;

        // Enviar una solicitud AJAX al servidor para obtener los datos de horas por mes
        fetch(`{{ route('mostrarHorasPorMes', ['voluntario' => $voluntario]) }}`, {
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
                            },
                            {
                                label: 'Media de Horas Voluntariado por Mes',
                                data: Object.values(data.mediaHorasPorMes),
                                backgroundColor: 'rgba(255, 0, 0, 0.2)', // Color rojo con transparencia
                                borderColor: 'rgba(255, 0, 0, 1)', // Color rojo sólido para el borde
                                borderWidth: 1
                            }
                        ]
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
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    function confirmDelete() {
        Swal.fire({
            title: '¿Estás seguro de que deseas eliminar este voluntario?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '¡Sí, eliminar!',
            cancelButtonText: 'Cancelar',
            focusCancel: true, // Foco en el botón de cancelar
            customClass: {
                confirmButton: 'swal-confirm-btn',
                cancelButton: 'swal-cancel-btn'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    '¡Eliminado!',
                    'El voluntario ha sido eliminado.',
                    'success'
                ).then(() => {
                    // Enviar el formulario después de mostrar el mensaje de éxito
                    document.getElementById('deleteForm').submit();
                });
            }
        })
    }
</script>


