
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recuperar contraseña</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
       body {
        background-color: #0056b3; /* Verde/Azul oscuro */
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">¿Olvidaste tu contraseña?</h5>
                            <p class="card-text text-muted">No hay problema. Solo indícanos tu dirección de correo electrónico y te enviaremos un enlace para restablecer la contraseña.</p>
                            <!-- Session Status -->
                            <div class="mb-4">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <!-- Email Address -->
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Enviar enlace para restablecer la contraseña</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    