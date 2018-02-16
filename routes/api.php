<?php

Route::post('login', 'AuthController@login')->name('login');
Route::post('logout', 'AuthController@logout');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('profile', 'UserController@index');
    Route::post('profile', 'UserController@update');

    Route::resource('slides', 'SlideController', ['except' => ['show']]);
    Route::get('get/slides/{slide}', 'SlideController@show');

    Route::get('users', 'UserController@get');
    Route::get('users/{user}', 'UserController@show');
});
