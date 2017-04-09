<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', ['as' => 'home', 'uses' => function(){return view('index');}]);
Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
    Route::post('ajax/validate/user/registration', ['as' => 'validateUserRegistration', 'uses' => 'RegisterController@validateAjax']);
    Route::post('ajax/validate/user/recover-password', ['as' => 'validateUserEmail', 'uses' => 'LoginController@validateAjax']);
    Route::post('user/register', ['as' => 'registerUser', 'uses' => 'RegisterController@register']);
    Route::post('user/forgot-password', ['as' => 'forgotPasswordUser', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
    Route::post('user/login', ['as' => 'loginUser', 'uses' => 'LoginController@login']);
    Route::get('user/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
    Route::get('user/reset-password/{email}/{token}', ['as' => 'resetPassword', 'uses' => 'ResetPasswordController@showResetForm']);
    Route::post('user/reset-password', ['as' => 'doResetPassword', 'uses' => 'ResetPasswordController@reset']);
});
Route::group(['namespace' => 'Auth', 'middleware' => 'auth'], function () {
    Route::get('user/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
});
Route::get('dashboard', ['as' => 'dashboard', 'uses' => function(){return view('dashboard.index');}]);


