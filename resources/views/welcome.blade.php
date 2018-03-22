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
    <link href="{{ asset('css/now-ui-kit-pro.css') }}" rel="stylesheet" />

    <!-- <link href="{{ asset('plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}"> -->

    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/front.css') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.base_url = "{{ getenv('VUE_BASE_URL', '/') }}";
        window.app_url = "{{ getenv('APP_URL') }}";
        window.app_name = "{{ getenv('APP_NAME', '/') }}";
        window.stripe_key = "{{ getenv('STRIPE_KEY') }}";
    </script>
</head>

<body class="sidebar-collapse">
    <div id="root"></div>
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

<!-- Plugin for DateTime Picker -->
<!-- <script src="{{ asset('plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script> -->

<!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('js/now-ui-kit.js?v=1.1.0') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

</html>