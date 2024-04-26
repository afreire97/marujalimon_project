<x-layout>



    <script src="{{asset('calendar/plugins/moment.js')}}"></script>
    <script src="{{asset('calendar/plugins/fullcalendar/core/index.global.js')}}"></script>
    <script src="{{asset('calendar/plugins/fullcalendar/daygrid/index.global.min.js')}}"></script>
    <script src="{{asset('calendar/plugins/fullcalendar/timegrid/index.global.min.js')}}"></script>
    <script src="{{asset('calendar/plugins/fullcalendar/interaction/index.global.js')}}"></script>
    <script src="{{asset('calendar/plugins/fullcalendar/list/index.global.min.js')}}"></script>
    <script src="{{asset('calendar/plugins/fullcalendar/bootstrap/index.global.js')}}"></script>
    <script src="{{asset('js/blog/app.min.js')}}"></script>
    <script src="{{asset('js/blog/vendor.min.js')}}"></script>
    <script src="{{asset('js/calendar/calendar.demo.js')}}"></script>


            <!-- BEGIN breadcrumb -->
            <ol class="breadcrumb float-xl-end">
                <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                <li class="breadcrumb-item active">Calendar</li>
            </ol>
            <!-- END breadcrumb -->
            <!-- BEGIN page-header -->

            <!-- END page-header -->
            <hr />
            <!-- BEGIN row -->
          <!-- BEGIN row -->
<div class="row">
    <!-- BEGIN event-list -->
    <div class="d-none d-lg-block" style="width: 215px">
        <div id="external-events" class="fc-event-list">
            <h5 class="mb-3">Turno</h5>
            <div class="fc-event" data-color="#00acac">
                <div class="fc-event-text">Mañana</div>
                <div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-success"></i></div>
            </div>
            <div class="fc-event" data-color="#348fe2">
                <div class="fc-event-text">Tarde</div>
                <div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-blue"></i></div>
            </div>


            <hr class="bg-grey-lighter my-3" />

            <h5 class="mb-3">Lugares</h5>
            @foreach ($lugares as $lugar)
            <div class="fc-event lugar" data-lugar-id="{{$lugar->LUG_id}}" data-color="#348fe2">
                <div class="fc-event-text">{{$lugar->LUG_nombre}}</div>
                <div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-blue"></i></div>
            </div>

        @endforeach



           <!-- Agrega el siguiente código al final del archivo HTML -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="panel-informativo-content">
            <h2 id="nombre-lugar-modal"></h2>
            <ul id="lista-tareas-modal"></ul>
          </div>
        </div>
      </div>
    </div>
  </div>
            <hr class="bg-grey-lighter my-3" />

            <h5 class="mb-3">Other Events</h5>
            <div id="drop-container" class="d-inline-block mx-auto">
                <i class="fas fa-trash-alt" style="color: red; font-size: 66px;"></i>
            </div>


            <div class="fc-event" data-color="#b6c2c9"></div>

        </div>
    </div>
    <!-- END event-list -->
    <div class="col-lg d-flex align-items-center justify-content-center">
        <!-- BEGIN calendar -->
        <div id="calendar" class="calendar calendarContainer"></div>
        <!-- END calendar -->
    </div>
</div>
<!-- END row -->
<script>
    document.querySelectorAll('.lugar').forEach(item => {
        item.addEventListener('click', event => {

            const lugarId = item.getAttribute('data-lugar-id');

            // Realizar una solicitud AJAX para obtener las tareas relacionadas con el lugar
            fetch(`/obtener-tareas-lugar/${lugarId}`)
                .then(response => response.json())
                .then(data => {



                    document.getElementById('nombre-lugar').textContent = data.lugar.LUG_nombre;

                    const listaTareas = document.getElementById('lista-tareas');
                    listaTareas.innerHTML = '';

                    // Agregar cada tarea a la lista
                    data.tareas.forEach(tarea => {
                        const tareaItem = document.createElement('li');
                        tareaItem.textContent = tarea.TAR_nombre;
                        listaTareas.appendChild(tareaItem);
                    });

                    document.getElementById('panel-informativo').style.display = 'block';
                })

        });
    });
</script>
<script>
    document.querySelectorAll('.lugar').forEach(item => {
      item.addEventListener('click', event => {
        const lugarId = item.getAttribute('data-lugar-id');

        // Realizar una solicitud AJAX para obtener las tareas relacionadas con el lugar
        fetch(`/obtener-tareas-lugar/${lugarId}`)
          .then(response => response.json())
          .then(data => {
            document.getElementById('nombre-lugar-modal').textContent = data.lugar.LUG_nombre;

            const listaTareasModal = document.getElementById('lista-tareas-modal');
            listaTareasModal.innerHTML = '';

            // Agregar cada tarea a la lista
            data.tareas.forEach(tarea => {
              const tareaItem = document.createElement('p');
              tareaItem.textContent = tarea.TAR_nombre;
              listaTareasModal.appendChild(tareaItem);
            });

            // Mostrar la ventana modal
            $('#myModal').modal('show');
          });
      });
    });
  </script>



    </x-layout>
