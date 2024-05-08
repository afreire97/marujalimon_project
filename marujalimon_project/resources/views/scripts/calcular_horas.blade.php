<script>
    // Seleccionar el formulario por su ID
    var calcularHorasForm = document.getElementById('calcularHorasForm');

    // Adjuntar evento de envío al formulario
    calcularHorasForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        // Obtener los valores de fecha de inicio y fin del formulario
        var fechaInicio = document.getElementById('fecha_inicio').value;
        var fechaFin = document.getElementById('fecha_fin').value;

        // Construir la URL con los parámetros de fecha
        var url = this.action + '?fecha_inicio=' + fechaInicio + '&fecha_fin=' + fechaFin;

        console.log(url);
        // Realizar una petición Ajax para enviar el formulario
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Mostrar el SweetAlert con el total de horas
                Swal.fire({
                    title: 'Total de horas realizadas',
                    text: 'El voluntario ha realizado ' + data.totalHoras + ' horas.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            })
            .catch(error => {
                console.error('Error al enviar el formulario:', error);
                // Manejar errores si es necesario
            });
    });
</script>
