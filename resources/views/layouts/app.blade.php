<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />

    <script>
        window.base_url = "{{ env('VUE_BASE_URL', '/') }}";
        window.app_name = "{{ env('APP_NAME', '/') }}";
    </script>
</head>

<body class="sidebar-collapse">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-primary fixed-top">
        <div class="container">
            <div class="dropdown button-dropdown">
                <a href="#slide-monster" class="dropdown-toggle" id="navbarDropdown" data-toggle="{{ auth()->check() ? 'dropdown' : '' }}">
                    <span class="button-bar"></span>
                    <span class="button-bar"></span>
                    <span class="button-bar"></span>
                </a>
                @if(auth()->check())
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-header">{{ auth()->user()->name }}</a>
                    <a href="{{ env('VUE_BASE_URL') }}profile" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="nav-link" href="{{ env('VUE_BASE_URL') }}api/logout"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
                @endif
            </div>
            <div class="navbar-translate">
                <a class="navbar-brand" href="{{ env('VUE_BASE_URL') }}">{{ env('APP_NAME') }}</a>
                <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation" data-nav-image="img/blurred-image-1.jpg">
                <ul class="navbar-nav">
                @guest
                    <li v-if="guest" class="nav-item">
                        <a href="{{ env('VUE_BASE_URL') }}login" class="nav-link">Login</a>
                    </li>
                    <li v-if="guest" class="nav-item">
                        <a href="{{ env('VUE_BASE_URL') }}register" class="nav-link">Register</a>
                    </li>
                @endguest
                
                @if(auth()->check())
                    <li class="nav-item">
                        <a href="{{ env('VUE_BASE_URL') }}slides/create" class="nav-link">Add new</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ env('VUE_BASE_URL') }}register" class="nav-link">Profile</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ env('VUE_BASE_URL') }}api/logout"><i class="fa fa-sign-out"></i> Logout</a>
                    </li>
                @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    
    <div class="wrapper">
   
        @yield('content')
        @yield('scripts')
    </div>
</body>
<!--   Core JS Files   -->
<script src="{{ asset('js/core/jquery.3.2.1.min.js') }}"></script>
<script src="{{ asset('plugins/toast-master/js/jquery.toast.js') }}"></script>
<script src="{{ asset('js/core/popper.min.js') }}"></script>
<script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{ asset('js/plugins/bootstrap-switch.js') }}"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{ asset('js/plugins/nouislider.min.js') }}"></script>
<!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
<script src="{{ asset('js/plugins/bootstrap-datepicker.js') }}"></script>


<!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('js/now-ui-kit.js?v=1.1.0') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</html>