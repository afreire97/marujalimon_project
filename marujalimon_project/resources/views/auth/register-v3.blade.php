@extends('layouts.default', [
    'paceTop' => true,
    'appSidebarHide' => true,
    'appHeaderHide' => true,
    'appContentClass' => 'p-0',
])

@section('title', 'Register Page')

@section('content')
    <!-- BEGIN register -->
    <div class="register register-with-news-feed">
        <!-- BEGIN news-feed -->
        <div class="news-feed">
            <div class="news-image" style="background-image: url({{ asset('img/login-bg/login-bg-11.jpg') }})"></div>
            <div class="news-caption">
                <h4 class="caption-title"><b>Color</b> Admin App</h4>
                <p>
                    As a Color Admin app administrator, you use the Color Admin console to manage your organization’s
                    account, such as add new users, manage security settings, and turn on the services you want your team to
                    access.
                </p>
            </div>
        </div>
        <!-- END news-feed -->

        <!-- BEGIN register-container -->
        <div class="register-container">
            <!-- BEGIN register-header -->
            <div class="register-header mb-25px h1">
                <div class="mb-1">Sign Up</div>
                <small class="d-block fs-15px lh-16">Create your Color Admin Account. It’s free and always will be.</small>
            </div>
            <!-- END register-header -->

            <!-- BEGIN register-content -->
            <div class="register-content">
                <form method="POST" action="{{ route('register') }}" class="fs-13px">
                    @csrf

                    <div class="mb-3">
                        <label class="mb-2" for="name">Name <span class="text-danger">*</span></label>
                        <div class="row gx-3">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <input type="text" class="form-control fs-13px" placeholder="First name" name="name"
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
                        <input type="email" class="form-control fs-13px" placeholder="Email address" name="email"
                            :value="old('email')" required autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <label class="mb-2" for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control fs-13px" placeholder="Password" name="password" required
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <label class="mb-2" for="password_confirmation">Confirm Password <span
                                class="text-danger">*</span></label>
                        <input type="password" class="form-control fs-13px" placeholder="Confirm Password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" value="administrador" id="is_admin" name="role">
                        <label class="form-check-label" for="is_admin">
                            Administrador
                        </label>
                        <x-input-error :messages="$errors->get('is_admin')" class="mt-2" />
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" value="coordinador" id="is_coordinador"
                            name="role">
                        <label class="form-check-label" for="is_coordinador">
                            Coordinador
                        </label>
                        <x-input-error :messages="$errors->get('is_coordinador')" class="mt-2" />
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" value="voluntario" id="is_voluntario"
                            name="role">
                        <label class="form-check-label" for="is_voluntario">
                            Voluntario
                        </label>
                        <x-input-error :messages="$errors->get('is_voluntario')" class="mt-2" />
                    </div>



                    <div class="flex items-center justify-end mt-3">
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                            href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                        <button type="submit"
                            class="btn btn-theme d-block btn-lg h-45px fs-13px ms-4">{{ __('Register') }}</button>
                    </div>




                </form>

            </div>
            <!-- END register-content -->
        </div>
        <!-- END register-container -->
    </div>
    <!-- END register -->


    <script>

        let seleccion = document.getElementById('is_coordinador');
        let seleccion2 = document.getElementById('is_admin');


        console.log(seleccion);
        console.log(seleccion2);


    </script>
@endsection
