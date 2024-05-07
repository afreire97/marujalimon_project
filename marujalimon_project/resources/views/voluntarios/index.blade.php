<x-layout>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif


  

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('tabla/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>




    {{-- <a href="{{route('listarVoluntariosTabla')}}">Cambiar vista</a> --}}

    @include('components.chart-table', [

    ])





</x-layout>

<!-- Bootstrap and Additional JS Scripts -->
