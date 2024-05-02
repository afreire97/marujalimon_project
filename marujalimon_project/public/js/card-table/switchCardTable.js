document.addEventListener("DOMContentLoaded", function() {
    const cardView = document.getElementById("cardView");
    const tableView = document.getElementById("tableView");
    const toggleViewButton = document.getElementById("toggleViewButton");
    const modeDisplay = document.getElementById("modeDisplay"); // Asegúrate de tener un elemento con este id
    const paginacion = document.getElementById("paginacion");

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
        // Si la vista de tarjetas está visible, ocúltala y muestra la vista de tabla
        if (cardView.style.display !== "none") {
            cardView.style.display = "none";
            tableView.style.display = "block";
            paginacion.style.display = "none";
            modeDisplay.textContent = "Modo Tabla"; // Cambia el texto a Modo Tabla
        } else {
            // De lo contrario, muestra la vista de tarjetas y oculta la vista de tabla
            cardView.style.display = "flex";
            tableView.style.display = "none";
            paginacion.style.display = "block";
            modeDisplay.textContent = "Modo Cartas"; // Cambia el texto a Modo Cartas
            reflowCardLayout();
        }
    });
});
