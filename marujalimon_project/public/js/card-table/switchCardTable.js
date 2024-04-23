document.addEventListener("DOMContentLoaded", function() {
    const cardView = document.getElementById("cardView");
    const tableView = document.getElementById("tableView");
    const addHoursForm = document.getElementById("addHoursForm"); // Obtener el formulario
    const toggleViewButton = document.getElementById("toggleViewButton");
    const paginacion = document.getElementById("paginacion");

    addHoursForm.style.display = "none";

    // Función para forzar el reflujo del layout de las tarjetas
    function reflowCardLayout() {
        // Acciones para forzar el reflujo de la cuadrícula de tarjetas
        const originalOverflow = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        window.requestAnimationFrame(function() {
            document.body.style.overflow = originalOverflow;
        });
    }

    // Agrega un evento de clic al botón
    toggleViewButton.addEventListener("click", function() {
        // Si la vista de tarjetas está visible, ocúltala y muestra la vista de tabla y el formulario
        if (cardView.style.display !== "none") {
            cardView.style.display = "none";
            tableView.style.display = "block";
            addHoursForm.style.display = "block"; // Mostrar el formulario
            paginacion.style.display = "none";
        } else {
            // De lo contrario, muestra la vista de tarjetas y oculta la vista de tabla y el formulario
            cardView.style.display = "flex";
            tableView.style.display = "none";
            addHoursForm.style.display = "none"; // Ocultar el formulario
            paginacion.style.display = "block";
            reflowCardLayout();
        }
    });
});
