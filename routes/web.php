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

Route::get('/login', ['as' => 'login', 'uses' => function () {
    return view('index', ['login' => 'true']);
}]);

//Registro e login de usuários
Route::group(['namespace' => 'Auth'], function () {
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
Route::get('dashboard', ['as' => 'dashboard', 'middleware' => 'auth', 'uses' => function () {
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

//Dashboard - Empresa
Route::group(['prefix' => 'dashboard/empresas', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'listEmpresaToUser', 'uses' => 'EmpresaController@index']);
    Route::get('new', ['as' => 'newEmpresa', 'uses' => 'EmpresaController@new']);
    Route::post('new', ['uses' => 'EmpresaController@store']);
    Route::get('view/{id}', ['as' => 'showEmpresaToUser', 'uses' => 'EmpresaController@view']);
    Route::get('vieaw/{id}', ['as' => 'showEmpresaToAdmin', 'uses' => 'EmpresaController@view']);
    Route::post('validate/socio', ['as' => 'validateEmpresaSocio', 'uses' => 'EmpresaController@validateSocio']);
    Route::post('validate/empresa', ['as' => 'validateEmpresa', 'uses' => 'EmpresaController@validateAjax']);

});

//Dashboard - Funcionários
Route::group(['prefix' => 'dashboard/funcionarios', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'listFuncionarioToUser', 'uses' => 'FuncionarioController@index']);
    Route::post('validate', ['as' => 'validateFuncionario', 'uses' => 'FuncionarioController@validateFuncionario']);
    Route::post('validate/dependente', ['as' => 'validateDependente', 'uses' => 'FuncionarioController@validateDependente']);
    Route::post('validate/documento', ['as' => 'validateDocumentoFuncionario', 'uses' => 'FuncionarioDocumentoController@validateDocumento']);

});
Route::group(['prefix' => 'dashboard/empresas', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('{idEmpresa}/funcionarios/new', ['as' => 'newFuncionario', 'uses' => 'FuncionarioController@new']);
    Route::post('{idEmpresa}/funcionarios/new', ['uses' => 'FuncionarioController@store']);
    Route::post('{idEmpresa}/funcionarios/newa', ['as' => 'showFuncionarioToAdmin', 'uses' => 'FuncionarioController@store']);
    Route::get('{idEmpresa}/funcionarios/view/{idFuncionario}', ['as' => 'showFuncionarioToUser', 'uses' => 'FuncionarioController@view']);
    Route::get('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['as' => 'listDocumentosFuncionarioToUser', 'uses' => 'FuncionarioDocumentoController@index']);
    Route::post('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['uses' => 'FuncionarioDocumentoController@store']);
});

//Dashboard - Atendimento
Route::group(['prefix' => 'dashboard/atendimento', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'listAtendimentosToUser', 'uses' => 'AtendimentoController@index']);
});

//Dashboard - Chamados
Route::group(['prefix' => 'dashboard/chamados', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('new', ['as' => 'newChamado', 'uses' => 'ChamadoController@new']);
    Route::post('new', ['uses' => 'ChamadoController@store']);
    Route::get('view/{id}', ['as' => 'viewChamado', 'uses' => 'ChamadoController@view']);
    Route::post('validate', ['as' => 'validateChamado', 'uses' => 'ChamadoController@validateChamado']);
});

//Dashboard - Anexo
Route::group(['prefix' => 'anexo', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::post('temp', ['as' => 'sendAnexoToTemp', 'uses' => 'AnexoController@sendToTemp']);
    Route::post('removeTemp', ['as' => 'removeAnexoFromTemp', 'uses' => 'AnexoController@removeFromTemp']);

});

//Dashboard - Usuário
Route::group(['prefix' => 'dashboard/usuario', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'editPerfil', 'uses' => 'UsuarioController@view']);
    Route::post('', ['uses' => 'UsuarioController@update']);
    Route::post('upload/foto', ['as'=>'uploadUsuarioFoto', 'uses' => 'UsuarioController@uploadFoto']);

});

//Admin - Abertura de Empresa
Route::group(['prefix' => 'admin/abertura-empresa', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::get('view/{id}', ['as' => 'showAberturaEmpresaToAdmin', 'uses' => 'AberturaEmpresaController@view']);
});

//Ajax
Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax', 'middleware' => 'auth'], function () {
    Route::post('cnae/search/code', ['as' => 'searchCnaeByCode', 'uses' => 'AjaxController@searchCnaeByCode']);
    Route::post('cnae/search/description', ['as' => 'searchCnaeByDescription', 'uses' => 'AjaxController@searchCnaeByDescription']);
    Route::post('messages/send', ['as' => 'sendMessageAjax', 'uses' => 'AjaxController@sendMessage']);
    Route::post('messages/update', ['as' => 'updateMessagesAjax', 'uses' => 'AjaxController@updateMessages']);
    Route::post('messages/upload', ['as' => 'uploadChatFileAjax', 'uses' => 'AjaxController@uploadChatFile']);
    Route::get('payment/params', ['as' => 'getMonthlyPaymentParams', 'uses' => 'AjaxController@getMonthlyPaymentParams']);
});


