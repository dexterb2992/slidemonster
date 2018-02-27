<?php
Route::post('login', 'AuthController@login')->name('login');
Route::post('logout', 'AuthController@logout');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('profile', 'UserController@index');
    Route::post('profile', 'UserController@update');
    Route::post('subscribe', 'UserController@subscribe');

    Route::resource('slides', 'SlideController', ['except' => ['show']]);
    Route::get('get/slides/{slide}', 'SlideController@show');

    Route::get('users', 'UserController@get');
    Route::get('users/{user}', 'UserController@show');

    Route::get('plans', 'SubscriptionPlanController@index');
    Route::get('plans/{id}', 'SubscriptionPlanController@retrieve');
    Route::get('plans/{plan_id}/features', 'SubscriptionPlanController@features');

    Route::get('coupons', 'UserController@checkCoupon');

    // Route::delete('features/{feature}/delete', 'FeatureController@destroy');
    Route::resource('features', 'FeatureController');
});
