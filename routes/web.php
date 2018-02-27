<?php

Route::get('s3', function (Illuminate\Http\Request $request) {
    if ($request->has('email_login')) {

        // $request->flashOnly(['email_login']); // I want to use this, but doesn't work either
        dump($request->email_login);
        session(['test' => $request->email_login]); // This DOES NOT get stored in the session

        session(['test3' => 'C']); // This DOES NOT get stored in the session

        echo  'yes we come here'; // This DOES output
    }

    session(['test2' => 'B']); // This DOES get flashed to the session
    dump(session()->all());
    session()->flush();
});

Route::get('try', 'SubscriptionPlanController@retrievePlan');
Route::get('test', 'SubscriptionPlanController@index');

// Password reset routes
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::redirect('/home', '/');

Route::get('/{any}', function () {
    return view('welcome');
})->where(['any' => '.*']);
