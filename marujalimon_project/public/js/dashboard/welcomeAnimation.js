document.addEventListener('DOMContentLoaded', function() {
            const welcomeMessage = document.getElementById('welcomeMessage');
            const container = document.getElementById('delayed-container');

            if (welcomeMessage && container) {
                const firstVisit = sessionStorage.getItem('firstVisit');

                if (!firstVisit) {
                    // Animación para el mensaje de bienvenida
                    welcomeMessage.style.opacity = 0;
                    window.requestAnimationFrame(function() {
                        welcomeMessage.style.transition = 'opacity 8s';
                        welcomeMessage.style.opacity = 1;
                    });

                    // Animación para contenedor con delay
                    setTimeout(function() {
                        container.style.opacity = '1';
                        container.style.visibility = 'visible';
                    }, 6000); // Retraso de 6 segundos

                    // Marcar que el usuario ya ha visitado el dashboard
                    sessionStorage.setItem('firstVisit', 'true');
                } else {
                    // Si no es la primera visita en la misma sesión, mostrar los elementos inmediatamente
                    welcomeMessage.style.opacity = 1;
                    container.style.opacity = '1';
                    container.style.visibility = 'visible';
                }
            } else {
                console.error('Error: Elementos del DOM no encontrados.');
            }
        });
