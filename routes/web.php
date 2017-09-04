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
    $atendimento = false;
    $horario1 = \DateTime::createFromFormat('H:i a', '8:00 am');
    $horario2 = \DateTime::createFromFormat('H:i a', '12:00 pm');
    $horario3 = \DateTime::createFromFormat('H:i a', '1:30 pm');
    $horario4 = \DateTime::createFromFormat('H:i a', '6:00 pm');

    $horario_atual = \DateTime::createFromFormat('H:i a', date('h:i A'));
    if (date('w') <= 5 && date('w') >= 1 && (($horario1 <= $horario_atual && $horario2 >= $horario_atual) || ($horario3 <= $horario_atual && $horario4 >= $horario_atual))) {
        $atendimento = true;
    }
    return view('index', compact('atendimento'));
}]);

Route::get('/login', ['as' => 'login', 'uses' => function () {
    $atendimento = false;
    $horario1 = \DateTime::createFromFormat('H:i a', '8:00 am');
    $horario2 = \DateTime::createFromFormat('H:i a', '12:00 pm');
    $horario3 = \DateTime::createFromFormat('H:i a', '1:30 pm');
    $horario4 = \DateTime::createFromFormat('H:i a', '6:00 pm');
    $intended = redirect()->intended()->getTargetUrl();
    $horario_atual = \DateTime::createFromFormat('H:i a', date('h:i A'));
    if (date('w') <= 5 && date('w') >= 1 && (($horario1 <= $horario_atual && $horario2 >= $horario_atual) || ($horario3 <= $horario_atual && $horario4 >= $horario_atual))) {
        $atendimento = true;
    }
    return view('index', ['login' => 'true', 'atendimento' => $atendimento, 'intended'=>$intended]);
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

Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'middleware' => 'auth'], function () {
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

//Dashboard - Demissão
Route::group(['prefix' => 'dashboard/demissao', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'listDemissaoToUser', 'uses' => 'DemissaoController@index']);
    Route::get('new/{idFuncionario}', ['as' => 'newDemissao', 'uses' => 'DemissaoController@new']);
    Route::post('new/{idFuncionario}', ['uses' => 'DemissaoController@store']);
    Route::get('view/{idDemissao}', ['as' => 'showDemissaoToUser', 'uses' => 'DemissaoController@view']);
    Route::post('validate', ['as' => 'validateDemissao', 'uses' => 'DemissaoController@validateDemissao']);
});

//Dashboard - Alterações contratuais
Route::group(['prefix' => 'dashboard/funcionarios', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('{idFuncionario}/alteracao-contratual', ['as' => 'listAlteracaoContratualToUser', 'uses' => 'AlteracaoContratualController@index']);
    Route::get('{idFuncionario}/alteracao-contratual/new', ['as' => 'newAlteracaoContratual', 'uses' => 'AlteracaoContratualController@new']);
    Route::post('{idFuncionario}/alteracao-contratual/new', ['uses' => 'AlteracaoContratualController@store']);
    Route::get('{idFuncionario}/alteracao-contratual/view/{idAlteracao}', ['as' => 'showAlteracaoContratualToUser', 'uses' => 'AlteracaoContratualController@view']);
    Route::post('alteracao-contratual/validate', ['as' => 'validateAlteracaoContratual', 'uses' => 'AlteracaoContratualController@validateAlteracao']);
});

//Dashboard - Ponto
Route::group(['prefix' => 'dashboard/pontos', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'listPontosToUser', 'uses' => 'PontoController@index']);
    Route::get('view/{idPonto}', ['as' => 'showPontoToUser', 'uses' => 'PontoController@view']);
    Route::get('send/{idPonto}', ['as' => 'sendPontos', 'uses' => 'PontoController@send']);
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

//Dashboard - Processo Folha
Route::group(['prefix' => 'dashboard/processamento-folha', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('', ['as' => 'listProcessoFolhaToUser', 'uses' => 'ProcessoFolhaController@index']);
    Route::get('view/{idProcesso}', ['as' => 'showProcessoFolhaToUser', 'uses' => 'ProcessoFolhaController@view']);
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
    Route::get('sem-movimento/{id}', ['as' => 'apuracaoSemMovimentacaoUser', 'uses' => 'ApuracaoController@semMovimento']);
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

Route::group(['namespace' => 'Cron', 'prefix' => 'cron'], function () {
    Route::get('daily', ['uses' => 'CronController@dailyCron']);
    Route::get('mensalidade/adjustmentMessage', ['uses' => 'CronController@AdjustmentInMensalidade']);
    Route::get('funcionarios/requestPontos', ['uses' => 'CronController@openPontosRequest']);
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

//Admin - Demissão
Route::group(['prefix' => 'admin/demissao', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listDemissaoToAdmin', 'uses' => 'DemissaoController@index']);
    Route::get('view/{idDemissao}', ['as' => 'showDemissaoToAdmin', 'uses' => 'DemissaoController@view']);
    Route::get('finish/{idDemissao}', ['as' => 'finishDemissao', 'uses' => 'DemissaoController@finish']);

});


//Admin - Alteração Contratual
Route::group(['prefix' => 'admin/alteracao-contratual', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listAlteracaoContratualToAdmin', 'uses' => 'AlteracaoContratualController@index']);
    Route::get('view/{idAlteracao}', ['as' => 'showAlteracaoContratualToAdmin', 'uses' => 'AlteracaoContratualController@view']);
    Route::post('view/{idAlteracao}', ['uses' => 'AlteracaoContratualController@update']);
});

//Admin - Empresa
Route::group(['prefix' => 'admin/empresas', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listEmpresaToAdmin', 'uses' => 'EmpresaController@index']);
    Route::get('view/{id}', ['as' => 'showEmpresaToAdmin', 'uses' => 'EmpresaController@view']);
    Route::get('activate/{idEmpresa}', ['as' => 'activateEmpresa', 'uses' => 'EmpresaController@ativar']);
    Route::get('{idEmpresa}/funcionarios/view/{idFuncionario}', ['as' => 'showFuncionarioToAdmin', 'uses' => 'FuncionarioController@view']);
    Route::get('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['as' => 'listDocumentosFuncionarioToAdmin', 'uses' => 'FuncionarioDocumentoController@index']);
    Route::post('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['uses' => 'FuncionarioDocumentoController@store']);
    Route::get('{idEmpresa}/funcionarios/{idFuncionario}/ativar', ['as' => 'activateFuncionario', 'uses' => 'FuncionarioController@activate']);
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
    Route::get('cancel/{idAlteracao}', ['as' => 'cancelAlteracao', 'uses' => 'AlteracaoController@cancel']);
    Route::get('finish/{idAlteracao}', ['as' => 'finishAlteracao', 'uses' => 'AlteracaoController@finish']);
});

//Admin - Apurações
Route::group(['prefix' => 'admin/apuracao', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listApuracoesToAdmin', 'uses' => 'ApuracaoController@index']);
    Route::get('view/{idApuracao}', ['as' => 'showApuracaoToAdmin', 'uses' => 'ApuracaoController@view']);
    Route::post('view/{idApuracao}', ['uses' => 'ApuracaoController@update']);
    Route::post('view/{idApuracao}/upload/guia', ['uses' => 'ApuracaoController@uploadGuia']);
    Route::post('validate/guia', ['as' => 'validateGuia', 'uses' => 'ApuracaoController@validateGuia']);
});

//Admin - Usuários
Route::group(['prefix' => 'admin/usuarios', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listUsuariosToAdmin', 'uses' => 'UsuarioController@index']);
    Route::get('view/{idUsuario}', ['as' => 'showUsuarioToAdmin', 'uses' => 'UsuarioController@view']);
});

//Admin - Pró-labores
Route::group(['prefix' => 'admin/pro-labore', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listProLaboresToAdmin', 'uses' => 'ProLaboreController@index']);
    Route::get('send/{idSocio}', ['as' => 'createProLabore', 'uses' => 'ProLaboreController@create']);
    Route::post('send/{idSocio}', ['uses' => 'ProLaboreController@store']);
    Route::post('validate', ['as' => 'validateProLabore', 'uses' => 'ProLaboreController@validateProLabore']);
    Route::post('validate/guia', ['as' => 'validateGuiaProLabore', 'uses' => 'ProLaboreController@validateGuia']);
});

//Admin - Processo Folha
Route::group(['prefix' => 'admin/processamento-folha', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listProcessoFolhaToAdmin', 'uses' => 'ProcessoFolhaController@index']);
    Route::get('send/{idEmpresa}', ['as' => 'createProcessoFolha', 'uses' => 'ProcessoFolhaController@create']);
    Route::post('send/{idEmpresa}', ['uses' => 'ProcessoFolhaController@store']);
    Route::get('view/{idProcesso}', ['as' => 'showProcessoFolhaToAdmin', 'uses' => 'ProcessoFolhaController@view']);
    Route::post('validate', ['as' => 'validateProcessoFolha', 'uses' => 'ProcessoFolhaController@validateProcesso']);
    Route::post('validate/arquivo', ['as' => 'validateProcessoFolhaArquivo', 'uses' => 'ProcessoFolhaController@validateArquivo']);
});

//Admin - Ordem Pagamento
Route::group(['prefix' => 'admin/pagamentos', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listOrdensPagamentoToAdmin', 'uses' => 'PagamentoController@index']);
    Route::get('view/{id}', ['as' => 'showOrdemPagamentoToAdmin', 'uses' => 'PagamentoController@index']);
});

//Admin - Documentos contábeis
Route::group(['prefix' => 'admin/documentos-contabeis', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listDocumentosContabeisToAdmin', 'uses' => 'DocumentoContabilController@index']);
    Route::get('view/{idProcesso}', ['as' => 'showDocumentoContabilToAdmin', 'uses' => 'DocumentoContabilController@view']);
    Route::get('view/{idProcesso}/contabilizar', ['as' => 'contabilizarDocumentoContabil', 'uses' => 'DocumentoContabilController@contabilizar']);
});

//Admin - Chamados
Route::group(['prefix' => 'admin/chamados', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('view/{id}', ['as' => 'showChamadoToAdmin', 'uses' => 'ChamadoController@view']);
    Route::get('finish/{id}', ['as' => 'finishChamado', 'uses' => 'ChamadoController@finish']);
    Route::get('reopen/{id}', ['as' => 'reopenChamado', 'uses' => 'ChamadoController@reopen']);
});

//Admin - Ponto
Route::group(['prefix' => 'admin/pontos', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listPontosToAdmin', 'uses' => 'PontoController@index']);
    Route::get('view/{idPonto}', ['as' => 'showPontoToAdmin', 'uses' => 'PontoController@view']);
    Route::get('send/{idPonto}', ['as' => 'sendPontos', 'uses' => 'PontoController@send']);
});

//Admin - Chat
Route::group(['prefix' => 'admin/chat', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listChatToAdmin', 'uses' => 'ChatController@index']);
    Route::get('view/{idChat}', ['as' => 'showChatToAdmin', 'uses' => 'ChatController@view']);
    Route::get('activate/{idChat}', ['as' => 'ativarChat', 'uses' => 'ChatController@activate']);
    Route::get('terminate/{idChat}', ['as' => 'finalizarChat', 'uses' => 'ChatController@terminate']);
});

//Ajax
Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
    Route::post('cnae/search/code', ['as' => 'searchCnaeByCode', 'uses' => 'AjaxController@searchCnaeByCode']);
    Route::post('cnae/search/description', ['as' => 'searchCnaeByDescription', 'uses' => 'AjaxController@searchCnaeByDescription']);
    Route::post('messages/send', ['as' => 'sendMessageAjax', 'uses' => 'AjaxController@sendMessage']);
    Route::post('messages/update', ['as' => 'updateMessagesAjax', 'uses' => 'AjaxController@updateMessages']);
    Route::post('messages/upload', ['as' => 'uploadChatFileAjax', 'uses' => 'AjaxController@uploadChatFile']);
    Route::post('messages/read', ['as' => 'readMessagesAjax', 'uses' => 'AjaxController@readMessages']);
    Route::get('payment/params', ['as' => 'getMonthlyPaymentParams', 'uses' => 'AjaxController@getMonthlyPaymentParams']);
    Route::post('impostos', ['as' => 'getImpostos', 'uses' => 'AjaxController@getImpostos']);
    Route::get('impostos/details', ['as' => 'getDetailsImposto', 'uses' => 'AjaxController@getDetailsImposto']);
    Route::post('contato', ['as' => 'sendContato', 'uses' => 'AjaxController@sendContato']);
    Route::post('contato/validate', ['as' => 'validateContato', 'uses' => 'AjaxController@validateContato']);
    Route::post('chat/register', ['as' => 'registerChat', 'uses' => 'AjaxController@registerChat']);
    Route::post('chat/send-message', ['as' => 'sendMessageChatAjax', 'uses' => 'AjaxController@sendMessageChat']);
    Route::post('chat/update', ['as' => 'updateChatAjax', 'uses' => 'AjaxController@updateChat']);
    Route::get('chat/count', ['as' => 'chatCountAjax', 'uses' => 'AjaxController@chatCount']);
    Route::get('chat/notification', ['as' => 'chatNotificationAjax', 'uses' => 'AjaxController@chatNotification']);
    Route::post('files/upload', ['as' => 'uploadFile', 'uses' => 'AjaxController@uploadFile']);
});

//Pagseguro
Route::group(['namespace' => 'Pagseguro'], function () {
    Route::post('notifications', ['as' => 'pagseguroNotification', 'uses' => 'PagseguroController@notifications']);
});
