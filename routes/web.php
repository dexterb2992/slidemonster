<?php
Route::get('test', function () {
    // dd(env('STRIPE_KEY'));   
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    	<title></title>
    </head>
    <body>
    	<slidemonster id="slidemonster" slide-id="13" token="qZBZCtxQZS7Fxvxs3fuLuuwU6gH13WJB38DXPlq2t6gvAauaLvOqu7iQ25Gi"></slidemonster><script type="text/javascript" src="https://topdogimsolutions.com/slidemonster/js/embed.js?id=05fd8c41c6dc703e143b"></script>
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
