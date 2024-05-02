<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Asegúrate de que tu cuenta esté utilizando una contraseña larga y aleatoria para mantenerse segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="container mt-5 mb-5">
        @csrf
        @method('put')

        <div class="card shadow mt-6 space-y-6">
            <div class="card-body">
                <x-input-label for="update_password_current_password" :value="__('Contraseña Actual')" class="mb-3" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="card-body">
                <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" class="mb-3" />
                <x-text-input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="card-body">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" class="mb-3" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="card-footer flex items-center gap-4">
                <x-primary-button>{{ __('Guardar') }}</x-primary-button>

                @if (session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >{{ __('Guardado.') }}</p>
                @endif
            </div>
        </div>
    </form>

</section>