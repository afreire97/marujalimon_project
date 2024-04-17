<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="container mt-5 mb-5">
            @csrf
            @method('delete')

            <div class="card shadow">
                <div class="card-header text-white text-center">
                    <h3>{{ __('Are you sure you want to delete your account?') }}</h3>
                </div>

                <div class="card-body">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-md-end">
                            {{ __('Password') }} <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-6">
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="#" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-danger ms-3">Delete Account</button>
                </div>
            </div>
        </form>

    </x-modal>
</section>
