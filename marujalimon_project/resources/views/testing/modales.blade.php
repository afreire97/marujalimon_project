<x-layout>




  <!-- Botón "Demo" -->
<div class="container">
    <div class="row">
        <div class="col">
            <a href="#modal-dialog" class="btn btn-sm btn-success" data-bs-toggle="modal">Demo</a>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Añadir horas</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí está el formulario -->

                    <form action="{{ route('horas.añadir') }}" method="POST">
                        @csrf
                        <input type="hidden" name="voluntariosSeleccionados" id="voluntariosSeleccionados" value="">

                        <label for="horas">Horas:</label>
                        <input type="number" name="horas" id="horas" required>

                        <label for="tarea_id">Tarea:</label>
                        <select name="tarea_id" id="tarea_id" required>
                            @foreach ($tareas as $tarea)
                                <option value="{{ $tarea->TAR_id }}">{{ $tarea->TAR_nombre }}</option>
                            @endforeach
                        </select>

                        <button type="submit">Agregar</button>
                    </form>

            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
                <a href="javascript:;" class="btn btn-success">Action</a>
            </div>
        </div>
    </div>
</div>


    <div class="hljs-wrapper">
        <pre><code class="html" data-url="../assets/data/ui-modal-notification/code-2.json"></code></pre>
    </div>
    <!-- END hljs-wrapper -->



    <div class="hljs-wrapper">
        <pre><code class="html" data-url="../assets/data/ui-modal-notification/code-3.json"></code></pre>
    </div>
    <!-- END hljs-wrapper -->



    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script src="{{ asset('plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('plugins/cdn-assets/highlight.min.js') }}"></script>
    <script src="{{ asset('js/modal/render.highlight.js') }}"></script>
    <script src="{{ asset('js/modal/ui-modal-notification.demo.js') }}"></script> --}}



</x-layout>
