<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Borrar cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.') }}
        </p>
    </header>


    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="container mt-5 mb-5">
            @csrf
            @method('delete')

            <div class="card shadow">
                <div class="card-header text-white text-center">
                    <h3>{{ __('¿Estás seguro de que quieres eliminar tu cuenta?') }}</h3>
                </div>

                <div class="card-body">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Por favor, introduce tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.') }}
                    </p>

                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">
                            {{ __('Contraseña') }} <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6">
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="#" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-danger ms-3">Borrar Cuenta</button>
                </div>
            </div>
        </form>

    </x-modal>
</section>
