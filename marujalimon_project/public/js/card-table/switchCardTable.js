    document.addEventListener("DOMContentLoaded", function() {
        const cardView = document.getElementById("cardView");
        const tableView = document.getElementById("tableView");
        const toggleViewButton = document.getElementById("toggleViewButton");

        const paginacion = document.getElementById("paginacion");


        // Agrega un evento de clic al botón
        toggleViewButton.addEventListener("click", function() {
            // Si la vista de tarjetas está visible, ocúltala y muestra la vista de tabla
            if (cardView.style.display !== "none") {
                cardView.style.display = "none";
                tableView.style.display = "block";

                paginacion.style.display = "none";
            } else { // De lo contrario, muestra la vista de tarjetas y oculta la vista de tabla
                cardView.style.display = "block";
                tableView.style.display = "none";
            }
        });
    });

