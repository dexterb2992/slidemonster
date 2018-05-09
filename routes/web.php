<?php
Route::get('test', function () {
    //
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
