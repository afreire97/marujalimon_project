<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>MARUJALIMON</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />


	<script src="https://kit.fontawesome.com/5405ceca9d.js" crossorigin="anonymous"></script>


    <script src="{{ asset('tabla/assets/plugins/chart.umd.js') }}" ></script>

	<!-- ================== BEGIN BASE CSS STYLE ================== -->
<!-- Enlace al archivo vendor.min.css -->
<link href="{{ asset('css/blog/vendor.min.css') }}" rel="stylesheet" />

<!-- Enlace al archivo app.min.css -->
<link href="{{ asset('css/blog/app.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/blog/layout.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('css/calendar/styles_calendar.css')}}">
<link rel="stylesheet" href="{{asset('css/estilos_voluntario_form.css')}}">








	<!-- ================== END core-css ================== -->

</head>
<body>
	<!-- begin #header -->
	<div id="header" class="header navbar navbar-default navbar-expand-lg navbar-fixed-top ">
		<!-- begin container -->
		<div class="container">
			<!-- begin navbar-brand -->
			<a href="{{route('dashboard')}}" class="navbar-brand">
				<span class="brand-logo"></span>
				<span class="brand-text">
					MARUJALIMON
				</span>
			</a>
			<!-- end navbar-brand -->
			<!-- begin navbar-toggle -->
			<button type="button" class="navbar-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#header-navbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<!-- end navbar-toggle -->
			<!-- begin navbar-collapse -->
			<div class="collapse navbar-collapse" id="header-navbar">
				<ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-bs-toggle="dropdown">VOLUNTARIOS<b class="caret"></b></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('voluntarios.create')}}">Añadir nuevo voluntario</a>
                            <a class="dropdown-item" href="index_inverse_header.html">Page with Inverse Header</a>
                            <a class="dropdown-item" href="index.html">Default Header</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-bs-toggle="dropdown">COORDINADORES <b class="caret"></b></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="post_grid.html">Page with Grid View Blog Post</a>
                            <a class="dropdown-item" href="post_without_sidebar.html">Page without Sidebar</a>
                        </div>
                    </li>
                    <li><a href="about_me.html">ABOUT ME</a></li>
                    <li><a href="contact_us.html">CONTACT US</a></li>
                    <li><a href="https://wrapbootstrap.com/theme/color-admin-admin-template-front-end-WB0N89JMK">PURCHASE</a></li>
                    <li class="dropdown">
                        @guest
                            <a href="#" class="nav-link" data-bs-toggle="dropdown">Login/Register <b class="caret"></b></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                                <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                            </div>
                        @else
                            <a href="#" class="nav-link" data-bs-toggle="dropdown">{{ Auth::user()->name }} <b class="caret"></b></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="btn dropdown-item" type="submit">Logout</button>
                                </form>
                            </div>
                        @endguest
                    </li>
                </ul>

			</div>
			<!-- end navbar-collapse -->
		</div>
		<!-- end container -->
	</div>
	<!-- end #header -->


	<div class="">{{$slot}}</div>

	<!-- begin #footer -->


	<div id="footer-copyright" class="footer-copyright">
		<div class="container d-sm-flex">
			<span class="copyright d-block">&copy; 2024 Todos los derechos reservados</span>
			<ul class="social-media-list mt-2 mt-sm-0 flex-1">
			<a href="#">
<<<<<<< HEAD
            <img src="{{asset('img\logo\logo.png')}}" alt="Logo de la Empresa" style="height: 25px;"> <!-- Ajusta la altura según tus necesidades -->
=======
				<img src="{{ asset('img/logo/logo.png') }}" alt="facebook" class="social-media-icon" style="width: 100px;"/>
>>>>>>> 6346438d340064f8ce43d02e8a20a4aa8d33a4fa
        </a>
			</ul>
		</div>

	</div>
	<!-- end #footer-copyright -->
	<!-- BEGIN theme-panel -->
	<div class="theme-panel">
		<a href="javascript:;" data-toggle="theme-panel-expand" class="theme-collapse-btn"><i class="fa-solid fa-gear fa-spin-pulse"></i></a>
		<div class="theme-panel-content">
			<div class="theme-list clearfix">
				<div class="theme-list-item"><a href="javascript:;" class="bg-red" data-theme-class="theme-red" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Red" data-original-title="" title="">&nbsp;</a></div>
				<div class="theme-list-item"><a href="javascript:;" class="bg-pink" data-theme-class="theme-pink" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Pink" data-original-title="" title="">&nbsp;</a></div>
				<div class="theme-list-item"><a href="javascript:;" class="bg-orange" data-theme-class="theme-orange" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Orange" data-original-title="" title="">&nbsp;</a></div>
				<div class="theme-list-item"><a href="javascript:;" class="bg-yellow" data-theme-class="theme-yellow" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Yellow" data-original-title="" title="">&nbsp;</a></div>
				<div class="theme-list-item"><a href="javascript:;" class="bg-lime" data-theme-class="theme-lime" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Lime" data-original-title="" title="">&nbsp;</a></div>
				<div class="theme-list-item"><a href="javascript:;" class="bg-green" data-theme-class="theme-green" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Green" data-original-title="" title="">&nbsp;</a></div>
				<div class="theme-list-item active"><a href="javascript:;" class="bg-teal" data-theme-class="" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Default" data-original-title="" title="">&nbsp;</a></div>
				<div class="theme-list-item"><a href="javascript:;" class="bg-cyan" data-theme-class="theme-cyan" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Aqua" data-original-title="" title="">&nbsp;</a></div>
				<div class="theme-list-item"><a href="javascript:;" class="bg-blue" data-theme-class="theme-blue" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Blue" data-original-title="" title="">&nbsp;</a></div>
				<div class="theme-list-item"><a href="javascript:;" class="bg-purple" data-theme-class="theme-purple" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Purple" data-original-title="" title="">&nbsp;</a></div>
				<div class="theme-list-item"><a href="javascript:;" class="bg-indigo" data-theme-class="theme-indigo" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Indigo" data-original-title="" title="">&nbsp;</a></div>
				<div class="theme-list-item"><a href="javascript:;" class="bg-gray-500" data-theme-class="theme-gray-500" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Gray" data-original-title="" title="">&nbsp;</a></div>
			</div>
			<hr class="mb-0" />
			<div class="row mt-10px pt-3px">
				<div class="col-9 control-label text-dark fw-bold">
					<div>Modo Oscuro &nbsp;<i class="fa-solid fa-moon fa-fade"></i></div>
					<div class="lh-14 fs-13px">
						<small class="text-dark opacity-50">
						Ajusta la apariencia para reducir el deslumbramiento y darle un descanso a tus ojos.
						</small>
					</div>
				</div>
				<div class="col-3 d-flex">
					<div class="form-check form-switch ms-auto mb-0 mt-2px">
						<input type="checkbox" class="form-check-input" name="app-theme-dark-mode" id="appThemeDarkMode" value="1" />
						<label class="form-check-label" for="appThemeDarkMode">&nbsp;</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END theme-panel -->

<!-- ================== BEGIN core-js ================== -->
<!-- Enlace al archivo vendor.min.js -->
<script src="{{ asset('js/blog/vendor.min.js') }}"></script>

<!-- Enlace al archivo app.min.js -->
<script src="{{ asset('js/blog/app.min.js') }}"></script>


	<!-- ================== END core-js ================== -->


</body>
</html>
