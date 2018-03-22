<?php
Route::get('try', function () {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title></title>
    </head>
    <body>
        <slidemonster id="slidemonster" slide-id="5" token="TbbGDel1beWdaq6fn1XssqPaG0vLiHJvPcNzMApPPYKRUdAd1gXSrrZBFb26"></slidemonster><script type="text/javascript" src="https://topdogimsolutions.com/slidemonster/js/embed.js"></script>
    </body>
    </html>
    <?php
});

Route::get('try2', function () {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title></title>
    </head>
    <body>
        <timermonster data-id="20"></timermonster>
        
        <script src="http://topdogimsolutions.com/timer-monster/public/assets/js/timer-monster.min.js"></script>
        <script type="text/javascript">
            TimerMonster.init({
                token: '',
            });
        </script>
    </body>
    </html>
    <?php
});

// Route::get('try', 'SubscriptionPlanController@retrievePlan');
// Route::get('test', 'SubscriptionPlanController@index');

// Cashier webhook for failed subscriptions
Route::post(
    'stripe/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);

// Password reset routes
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::redirect('/home', '/');

Route::get('/{any}', function () {
    return view('welcome');
})->where(['any' => '.*']);
