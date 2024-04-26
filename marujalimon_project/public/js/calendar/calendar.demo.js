var handleCalendarDemo = function() {
    // Obtener el contenedor de eventos externos
    var externalEventsContainer = document.getElementById('external-events');

    // Variable para almacenar el evento seleccionado
    var selectedEvent = null;

    // Inicializar los eventos arrastrables
    var Draggable = FullCalendar.Interaction.Draggable;
    var draggable = new Draggable(externalEventsContainer, {
        itemSelector: '.fc-event',
        eventData: function(eventEl) {
            return {
                title: eventEl.querySelector('.fc-event-text').innerText,
                color: eventEl.getAttribute('data-color')
            };
        }
    });

    // Obtener el contenedor del calendario
    var calendarElm = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarElm, {
        headerToolbar: {
            left: 'dayGridMonth,timeGridWeek,timeGridDay',
            center: 'title',
            right: 'prev,next today'
        },
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day'
        },
        initialView: 'dayGridMonth',
        editable: true,
        droppable: true,


        themeSystem: 'bootstrap',
        events: [],

        eventClick: function(info) {
            selectedEvent = info.event;

        },

        eventDragStop: function(info) {
            selectedEvent = info.event; // Almacenar el evento seleccionado

            // Verificar si el evento se soltó sobre el contenedor de eliminación
            var dropContainer = document.getElementById('drop-container');
            var dropContainerRect = dropContainer.getBoundingClientRect();
            if (
                info.jsEvent.clientX >= dropContainerRect.left &&
                info.jsEvent.clientX <= dropContainerRect.right &&
                info.jsEvent.clientY >= dropContainerRect.top &&
                info.jsEvent.clientY <= dropContainerRect.bottom
            ) {
                if (selectedEvent != null) {

                        selectedEvent.setProp('display', 'none'); // Ocultar el evento

                            selectedEvent.remove(); // Eliminar el evento del calendario después de un breve retraso
                            selectedEvent = null; // Reiniciar el evento seleccionado

                }
            }
        }
    });



    // Verificar si el ratón pasa por encima del contenedor de eliminación


    // Renderizar el calendario
    calendar.render();
};

var Calendar = function() {
    "use strict";
    return {
        //main function
        init: function() {
            handleCalendarDemo();
        }
    };
}();

$(document).ready(function() {
    Calendar.init();
});
