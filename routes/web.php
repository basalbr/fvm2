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
//Home
Route::get('/', ['as' => 'home', 'uses' => function () {
    return view('index');
}]);

//Registro e login de usuários
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

//Dashboard - Home
Route::get('dashboard', ['as' => 'dashboard', 'uses' => function () {
    return view('dashboard.index');
}]);

//Dashboard - Abertura de Empresa
Route::group(['prefix' => 'dashboard/abertura-empresa', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'listAberturaEmpresaToUser', 'uses' => 'AberturaEmpresaController@index']);
    Route::get('new', ['as' => 'newAberturaEmpresa', 'uses' => 'AberturaEmpresaController@new']);
    Route::post('new', ['uses' => 'AberturaEmpresaController@store']);
    Route::get('view/{id}', ['as' => 'showAberturaEmpresaToUser', 'uses' => 'AberturaEmpresaController@view']);
    Route::post('validate/socio', ['as' => 'validateAberturaEmpresaSocio', 'uses' => 'AberturaEmpresaController@validateSocio']);
    Route::post('validate/abertura-empresa', ['as' => 'validateAberturaEmpresa', 'uses' => 'AberturaEmpresaController@validateAjax']);
});

//Admin - Abertura de Empresa
Route::group(['prefix' => 'admin/abertura-empresa', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::get('view/{id}', ['as' => 'showAberturaEmpresaToAdmin', 'uses' => 'AberturaEmpresaController@view']);
});

//Ajax
Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax', 'middleware' => 'auth'], function () {
    Route::post('cnae/search/code', ['as' => 'searchCnaeByCode', 'uses' => 'AjaxController@searchCnaeByCode']);
    Route::post('cnae/search/description', ['as' => 'searchCnaeByDescription', 'uses' => 'AjaxController@searchCnaeByDescription']);
    Route::get('payment/params', ['as' => 'getMonthlyPaymentParams', 'uses' => 'AjaxController@getMonthlyPaymentParams']);
});

