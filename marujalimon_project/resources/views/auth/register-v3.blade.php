<x-layout>

<!-- BEGIN register -->
<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header text-white text-center">
            <h3>Registrar Admin</h3>
        </div>
        <!-- Mensajes de éxito y de error -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="fs-13px">
            @csrf
            <div class="card-body">
                <!-- Campos del formulario -->
                <div class="mb-3">
                    <label class="mb-2" for="name">Nombre<span class="text-danger">*</span></label>
                    <div class="row gx-3">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <input type="text" class="form-control fs-13px" placeholder="Nombre" name="name"
                                :value="old('name')" required autofocus autocomplete="given-name" />
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control fs-13px" placeholder="DNI" name="dni"
                                :value="old('dni')" required autocomplete="family-name" />
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="mb-2" for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control fs-13px" placeholder="Email" name="email"
                        :value="old('email')" required autocomplete="email" />
                </div>

                <div class="mb-3">
                    <label class="mb-2" for="password">Contraseña <span class="text-danger">*</span></label>
                    <input type="password" class="form-control fs-13px" placeholder="Contraseña" name="password" required
                        autocomplete="new-password" />
                </div>

                <div class="mb-3">
                    <label class="mb-2" for="password_confirmation">Confirmar Contraseña<span class="text-danger">*</span></label>
                    <input type="password" class="form-control fs-13px" placeholder="Confirmar Contraseña"
                        name="password_confirmation" required autocomplete="new-password" />
                </div>
                
                <!-- Botones de acción -->
                <div class="mb-3 text-center">
                <a href="{{ url()->previous() }}" class="btn btn-primary" style="padding: 10px 20px; background-color:#6a6c6e; color:white">Volver</a>
                    <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Registrar</button>
                </div>
                <div class="mb-3 text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        ¿Ya estás registrado?
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END register -->

</x-layout>
