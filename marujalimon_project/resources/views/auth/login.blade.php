
@extends('layouts.default', [
    'paceTop' => true,
    'appSidebarHide' => true,
    'appHeaderHide' => true,
    'appContentClass' => 'p-0',
])

@section('title', 'Login Page')

@section('content')
    <!-- BEGIN login -->
    <div class="login login-with-news-feed">
        <!-- BEGIN news-feed -->
        <div class="news-feed">
            <div class="news-image" style="background-image: url({{ asset('img/login-bg/login-bg-11.jpg') }})"></div>
            <div class="news-caption">
                <h4 class="caption-title"><b>Color</b> Admin App</h4>
                <p>
                    Download the Color Admin app for iPhone®, iPad®, and Android™. Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit.
                </p>
            </div>
        </div>
        <!-- END news-feed -->

        <!-- BEGIN login-container -->
        <div class="login-container">
            <!-- BEGIN login-header -->
            <div class="login-header mb-30px">
                <div class="brand">
                    <div class="d-flex align-items-center">
                        <span class="logo"></span>
                        <b>Color</b> Admin
                    </div>
                    <small>Bootstrap 5 Responsive Admin Template</small>
                </div>
                <div class="icon">
                    <i class="fa fa-sign-in-alt"></i>
                </div>
            </div>
            <!-- END login-header -->

            <!-- BEGIN login-content -->
            <div class="login-content">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="fs-13px">
                    @csrf

                    <div class="form-floating mb-15px">
                        <x-text-input id="emailAddress" class="form-control h-45px fs-13px" type="email" name="email"
                            :value="old('email')" placeholder="Email Address" required autofocus autocomplete="username" />
                        <label for="emailAddress" class="d-flex align-items-center fs-13px text-gray-600">Email</label>
                    </div>

                    <div class="form-floating mb-15px">
                        <x-text-input id="password" class="form-control h-45px fs-13px" type="password" name="password"
                            placeholder="Password" required autocomplete="current-password" />
                        <label for="password" class="d-flex align-items-center fs-13px text-gray-600">Contraseña</label>
                    </div>

                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-check mb-30px">
                        <input class="form-check-input" type="checkbox" value="1" id="rememberMe" name="remember">
                        <label class="form-check-label" for="rememberMe">
                            Recordarme
                        </label>
                    </div>
{{-- 
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-primary">¿Olvidaste tu contraseña?</a>
                    @endif --}}

                    <div class="mb-15px">
                        <x-primary-button type="submit" class="btn btn-theme d-block h-45px w-100 btn-lg fs-14px">
                            Iniciar sesión
                        </x-primary-button>
                    </div>

                    <hr class="bg-gray-600 opacity-2" />

                    <div class="text-gray-600 text-center text-gray-500-darker mb-0">
                        &copy; Color Admin Todos los derechos reservados 2023
                    </div>
                </form>

            </div>
            <!-- END login-content -->
        </div>
        <!-- END login-container -->
    </div>
    <!-- END login -->
@endsection
