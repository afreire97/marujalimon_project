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

    console.log("Entramos al calendario");
    var calendarElm = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarElm, {
        headerToolbar: {
            left: 'dayGridMonth,timeGridWeek,timeGridDay',
            center: 'title',
            right: 'prev,next today'
        },
        buttonText: {
            today: 'Today',
            month: 'Mes',
            week: 'Semana',
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
        },
        eventReceive: function(info) {



            console.log('Evento recibido:', info.event);

            var fecha = info.event.start;
            var turno = info.event.extendedProps.turno;
            var lugarId = info.event.extendedProps.lugarId;

            console.log('Fecha:', fecha);
            console.log('Turno:', turno);
            console.log('Lugar ID:', lugarId);

            // Crear campos ocultos para almacenar los datos del evento
            var inputFecha = document.createElement('input');
            inputFecha.type = 'hidden';
            inputFecha.name = 'fechas[]';
            inputFecha.value = fecha.toISOString();

            var inputTurno = document.createElement('input');
            inputTurno.type = 'hidden';
            inputTurno.name = 'turnos[]';
            inputTurno.value = turno;

            var inputLugar = document.createElement('input');
            inputLugar.type = 'hidden';
            inputLugar.name = 'lugares[]';
            inputLugar.value = lugarId;

            // Agregar los campos ocultos al formulario
            var form = document.getElementById('evento-form');
            form.appendChild(inputFecha);
            form.appendChild(inputTurno);
            form.appendChild(inputLugar);

            // Imprimir los inputs del formulario en la consola
            console.log('Inputs del formulario:', form.querySelectorAll('input'));
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
