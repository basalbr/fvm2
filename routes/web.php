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

Route::get('/', function () {
    return view('index');
});
Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
    Route::post('ajax/validate/user/registration', ['as' => 'validateUserRegistration', 'uses' => 'RegisterController@validateAjax']);
    Route::post('ajax/validate/user/recover-password', ['as' => 'validateUserEmail', 'uses' => 'LoginController@validateAjax']);
    Route::post('user/register', ['as' => 'registerUser', 'uses' => 'RegisterController@register']);
    Route::post('user/login', ['as' => 'loginUser', 'uses' => 'LoginController@login']);
});
Route::get('dashboard', ['as' => 'dashboard', 'uses' => function(){return 'hello ' . Auth::user()->nome;}]);


