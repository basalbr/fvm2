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

Route::group(['namespace' => 'Dashboard', 'prefix'=>'dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
});

//Dashboard - Notificações
Route::group(['prefix' => 'notificacao', 'namespace' => 'Notificacao', 'middleware' => 'auth'], function () {
    Route::get('ler/{id}', ['as' => 'lerNotificacao', 'uses' => 'NotificacaoController@ler']);
});

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

//Dashboard - Ordem Pagamento
Route::group(['prefix' => 'dashboard/pagamentos', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'listOrdensPagamentoToUser', 'uses' => 'PagamentoController@index']);
});

//Dashboard - Funcionários
Route::group(['prefix' => 'dashboard/empresas', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('{idEmpresa}/funcionarios/new', ['as' => 'newFuncionario', 'uses' => 'FuncionarioController@new']);
    Route::post('{idEmpresa}/funcionarios/new', ['uses' => 'FuncionarioController@store']);
    Route::get('{idEmpresa}/funcionarios/view/{idFuncionario}', ['as' => 'showFuncionarioToUser', 'uses' => 'FuncionarioController@view']);
    Route::get('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['as' => 'listDocumentosFuncionarioToUser', 'uses' => 'FuncionarioDocumentoController@index']);
    Route::post('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['uses' => 'FuncionarioDocumentoController@store']);
});

//Dashboard - Alterações
Route::group(['prefix' => 'dashboard/solicitar-alteracao', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'listSolicitacoesAlteracaoToUser', 'uses' => 'AlteracaoController@index']);
    Route::get('new/{idTipo}', ['as' => 'newSolicitacaoAlteracao', 'uses' => 'AlteracaoController@new']);
    Route::post('new/{idTipo}', ['uses' => 'AlteracaoController@store']);
    Route::get('view/{idAlteracao}', ['as' => 'showSolicitacaoAlteracaoToUser', 'uses' => 'AlteracaoController@view']);
    Route::post('validate', ['as' => 'validateAlteracao', 'uses' => 'AlteracaoController@validateAlteracao']);
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

//Dashboard - Apurações
Route::group(['prefix' => 'dashboard/apuracao', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('calendario', ['as' => 'showCalendarioImpostos', 'uses' => 'ApuracaoController@calendario']);
    Route::get('', ['as' => 'listApuracoesToUser', 'uses' => 'ApuracaoController@index']);
    Route::get('view/{idApuracao}', ['as' => 'showApuracaoToUser', 'uses' => 'ApuracaoController@view']);
    Route::post('view/{idApuracao}', ['uses' => 'ApuracaoController@update']);
    Route::post('validate/anexo', ['as' => 'validateApuracaoAnexo', 'uses' => 'ApuracaoController@validateAnexo']);
    Route::post('sem-movimento', ['as' => 'apuracaoSemMovimentacaoUser', 'uses' => 'ApuracaoController@semMovimento']);
});

//Dashboard - Documentos contábeis
Route::group(['prefix' => 'dashboard/documentos-contabeis', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'listDocumentosContabeisToUser', 'uses' => 'DocumentoContabilController@index']);
    Route::get('view/{idProcesso}', ['as' => 'showDocumentoContabilToUser', 'uses' => 'DocumentoContabilController@view']);
    Route::get('view/{idProcesso}/sem-movimento', ['as' => 'flagDocumentosContabeisAsSemMovimento', 'uses' => 'DocumentoContabilController@semMovimento']);
    Route::post('view/{idProcesso}', ['uses' => 'DocumentoContabilController@update']);
});

//CRON
Route::group(['namespace' => 'Dashboard'], function () {
    Route::get('abrir-apuracoes', ['uses' => 'ApuracaoController@abrirApuracoes']);
    Route::get('abrir-documentos-contabeis', ['uses' => 'DocumentoContabilController@abrirProcessos']);
    Route::get('abrir-pagamento-mensalidades', ['uses' => 'PagamentoController@updateMensalidades']);
});

//Dashboard - Usuário
Route::group(['prefix' => 'dashboard/usuario', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'editPerfil', 'uses' => 'UsuarioController@view']);
    Route::post('', ['uses' => 'UsuarioController@update']);
    Route::post('upload/foto', ['as' => 'uploadUsuarioFoto', 'uses' => 'UsuarioController@uploadFoto']);
});

//Admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'adminHome', 'uses' => 'AdminController@index']);
});

//Admin - Atendimento
Route::group(['prefix' => 'admin/atendimento', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listAtendimentosToAdmin', 'uses' => 'AtendimentoController@index']);
});

//Admin - Abertura de Empresa
Route::group(['prefix' => 'admin/abertura-empresa', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listAberturaEmpresaToAdmin', 'uses' => 'AberturaEmpresaController@index']);
    Route::get('view/{id}', ['as' => 'showAberturaEmpresaToAdmin', 'uses' => 'AberturaEmpresaController@view']);
});

//Admin - Empresa
Route::group(['prefix' => 'admin/empresas', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listEmpresaToAdmin', 'uses' => 'EmpresaController@index']);
    Route::get('view/{id}', ['as' => 'showEmpresaToAdmin', 'uses' => 'EmpresaController@view']);
    Route::get('activate/{idEmpresa}', ['as' => 'activateEmpresa', 'uses' => 'EmpresaController@ativar']);
    Route::get('{idEmpresa}/funcionarios/view/{idFuncionario}', ['as' => 'showFuncionarioToAdmin', 'uses' => 'FuncionarioController@view']);
    Route::get('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['as' => 'listDocumentosFuncionarioToAdmin', 'uses' => 'FuncionarioDocumentoController@index']);
    Route::post('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['uses' => 'FuncionarioDocumentoController@store']);
});

//Admin - Funcionários
Route::group(['prefix' => 'admin/funcionarios', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listFuncionarioToAdmin', 'uses' => 'FuncionarioController@index']);
    Route::post('validate/documento', ['as' => 'validateDocumentoFuncionario', 'uses' => 'FuncionarioDocumentoController@validateDocumento']);
});

//Admin - Alterações
Route::group(['prefix' => 'admin/solicitar-alteracao', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listSolicitacoesAlteracaoToAdmin', 'uses' => 'AlteracaoController@index']);
    Route::get('view/{idAlteracao}', ['as' => 'showSolicitacaoAlteracaoToAdmin', 'uses' => 'AlteracaoController@view']);
});

//Admin - Apurações
Route::group(['prefix' => 'admin/apuracao', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('calendario', ['as' => 'showCalendarioImpostos', 'uses' => 'ApuracaoController@calendario']);
    Route::get('', ['as' => 'listApuracoesToAdmin', 'uses' => 'ApuracaoController@index']);
    Route::get('view/{idApuracao}', ['as' => 'showApuracaoToAdmin', 'uses' => 'ApuracaoController@view']);
    Route::post('view/{idApuracao}', ['uses' => 'ApuracaoController@update']);
    Route::post('validate/anexo', ['as' => 'validateApuracaoAnexo', 'uses' => 'ApuracaoController@validateAnexo']);
    Route::post('sem-movimento', ['as' => 'apuracaoSemMovimentacaoAdmin', 'uses' => 'ApuracaoController@semMovimento']);
});

//Admin - Ordem Pagamento
Route::group(['prefix' => 'admin/pagamentos', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listOrdensPagamentoToAdmin', 'uses' => 'PagamentoController@index']);
});

//Admin - Documentos contábeis
Route::group(['prefix' => 'admin/documentos-contabeis', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listDocumentosContabeisToAdmin', 'uses' => 'DocumentoContabilController@index']);
    Route::get('view/{idProcesso}', ['as' => 'showDocumentoContabilToAdmin', 'uses' => 'DocumentoContabilController@view']);
});

//Admin - Chamados
Route::group(['prefix' => 'admin/chamados', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('view/{id}', ['as' => 'showChamadoToAdmin', 'uses' => 'ChamadoController@view']);
});

//Ajax
Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
    Route::post('cnae/search/code', ['as' => 'searchCnaeByCode', 'uses' => 'AjaxController@searchCnaeByCode']);
    Route::post('cnae/search/description', ['as' => 'searchCnaeByDescription', 'uses' => 'AjaxController@searchCnaeByDescription']);
    Route::post('messages/send', ['as' => 'sendMessageAjax', 'uses' => 'AjaxController@sendMessage']);
    Route::post('messages/update', ['as' => 'updateMessagesAjax', 'uses' => 'AjaxController@updateMessages']);
    Route::post('messages/upload', ['as' => 'uploadChatFileAjax', 'uses' => 'AjaxController@uploadChatFile']);
    Route::get('payment/params', ['as' => 'getMonthlyPaymentParams', 'uses' => 'AjaxController@getMonthlyPaymentParams']);
    Route::post('impostos', ['as' => 'getImpostos', 'uses' => 'AjaxController@getImpostos']);
    Route::get('impostos/details', ['as' => 'getDetailsImposto', 'uses' => 'AjaxController@getDetailsImposto']);
    Route::post('contato', ['as' => 'sendContato', 'uses' => 'AjaxController@sendContato']);
    Route::post('contato/validate', ['as' => 'validateContato', 'uses' => 'AjaxController@validateContato']);
});

//Pagseguro

Route::group(['namespace' => 'Pagseguro', 'middleware' => 'auth'], function () {
    Route::post('notifications', ['as' => 'pagseguroNotification', 'uses' => 'PagseguroController@notifications']);
});
