<?php
Route::get('try', function () {
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    
    <!-- CSRF Token -->
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
</head>

<body class="sidebar-collapse">
    <timermonster data-id="20"></timermonster>
    <script src="http://topdogimsolutions.com/timer-monster/public/assets/js/timer-monster.min.js"></script>
    <script type="text/javascript">
        TimerMonster.init({
            token: '',
        });
    </script>

    <slidemonster id="slidemonster" slide-id="7" token="vyzWZfhtXGpwX8PWJJh3fAmKAtlRCtNlumh84z5LGRWIWkVMuxJbi14MUwut"></slidemonster><script type="text/javascript" src="http://slide-monster.local/js/embed.js"></script>
    <!-- <slidemonster id="slidemonster" slide-id="4" token="sUG96iRf7IijJgafcHkWXW8nrWMxFNUqzdED9eLjozbR4v3S4igdCoxWEUXQ"></slidemonster><script type="text/javascript" src="https://topdogimsolutions.com/slidemonster/js/embed.js"></script> -->
</body>

</html>
    <?php
});

// Password reset routes
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::redirect('/home', '/');

// Route::get('get/slides/{slide}', 'SlideController@show')->middleware('api');
Route::get('api/get/slides/{slide}', 'SlideController@show')->middleware('auth:api');

Route::get('/{any}', function () {
    return view('welcome');
})->where(['any' => '.*']);
