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
use App\Models\Noticia;
use Carbon\Carbon;

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
    $noticias = Noticia::where('data_publicacao', '<=', Carbon::today()->format('Y-m-d'))->orderBy('data_publicacao', 'desc')->orderBy('created_at', 'desc')->limit(3)->get();
    return view('index', compact('atendimento', 'noticias'));
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
    $noticias = Noticia::where('data_publicacao', '<=', Carbon::today()->format('Y-m-d'))->orderBy('data_publicacao', 'desc')->orderBy('created_at', 'desc')->limit(3)->get();
    return view('index', ['login' => 'true', 'atendimento' => $atendimento, 'intended' => $intended, 'noticias' => $noticias]);
}]);

//Noticias
Route::group(['namespace' => 'Home', 'prefix' => 'blog'], function () {
    Route::get('{noticia}', ['as' => 'showNoticiaToUser', 'uses' => 'NoticiaController@view']);
    Route::get('', ['as' => 'listNoticiasToUser', 'uses' => 'NoticiaController@index']);
});

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

Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

});
Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/blocked/payment', ['as' => 'blockedByPendingPayment', 'uses' => 'DashboardController@blockedByPendingPayment']);
});

//Dashboard -Décimo terceiro
Route::group(['prefix' => 'dashboard/decimo-terceiro', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listDecimoTerceiroToUser', 'uses' => 'DecimoTerceiroController@index']);
    Route::get('view/{id}', ['as' => 'showDecimoTerceiroToUser', 'uses' => 'DecimoTerceiroController@view']);
});

//Dashboard - Notificações
Route::group(['prefix' => 'notificacao', 'namespace' => 'Notificacao', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('ler/{id}', ['as' => 'lerNotificacao', 'uses' => 'NotificacaoController@ler']);
});

//Dashboard - Abertura de Empresa
Route::group(['prefix' => 'dashboard/abertura-empresa', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listAberturaEmpresaToUser', 'uses' => 'AberturaEmpresaController@index']);
    Route::get('new', ['as' => 'newAberturaEmpresa', 'uses' => 'AberturaEmpresaController@new']);
    Route::post('new', ['uses' => 'AberturaEmpresaController@store']);
    Route::get('view/{id}', ['as' => 'showAberturaEmpresaToUser', 'uses' => 'AberturaEmpresaController@view']);
    Route::post('validate/socio', ['as' => 'validateAberturaEmpresaSocio', 'uses' => 'AberturaEmpresaController@validateSocio']);
    Route::post('validate/abertura-empresa', ['as' => 'validateAberturaEmpresa', 'uses' => 'AberturaEmpresaController@validateAjax']);
});

//Dashboard - Empresa
Route::group(['prefix' => 'dashboard/empresas', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listEmpresaToUser', 'uses' => 'EmpresaController@index']);
    Route::get('new', ['as' => 'newEmpresa', 'uses' => 'EmpresaController@new']);
    Route::post('new', ['uses' => 'EmpresaController@store']);
    Route::get('view/{id}', ['as' => 'showEmpresaToUser', 'uses' => 'EmpresaController@view']);
    Route::post('validate/socio', ['as' => 'validateEmpresaSocio', 'uses' => 'EmpresaController@validateSocio']);
    Route::post('validate/empresa', ['as' => 'validateEmpresa', 'uses' => 'EmpresaController@validateAjax']);
});

//Dashboard - Funcionários
Route::group(['prefix' => 'dashboard/funcionarios', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
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
Route::group(['prefix' => 'dashboard/empresas', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('{idEmpresa}/funcionarios/new', ['as' => 'newFuncionario', 'uses' => 'FuncionarioController@new']);
    Route::post('{idEmpresa}/funcionarios/new', ['uses' => 'FuncionarioController@store']);
    Route::get('{idEmpresa}/funcionarios/view/{idFuncionario}', ['as' => 'showFuncionarioToUser', 'uses' => 'FuncionarioController@view']);
    Route::get('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['as' => 'listDocumentosFuncionarioToUser', 'uses' => 'FuncionarioDocumentoController@index']);
    Route::post('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['uses' => 'FuncionarioDocumentoController@store']);
});

//Dashboard - Demissão
Route::group(['prefix' => 'dashboard/demissao', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listDemissaoToUser', 'uses' => 'DemissaoController@index']);
    Route::get('new/{idFuncionario}', ['as' => 'newDemissao', 'uses' => 'DemissaoController@new']);
    Route::post('new/{idFuncionario}', ['uses' => 'DemissaoController@store']);
    Route::get('view/{idDemissao}', ['as' => 'showDemissaoToUser', 'uses' => 'DemissaoController@view']);
    Route::post('validate', ['as' => 'validateDemissao', 'uses' => 'DemissaoController@validateDemissao']);
});

//Dashboard - Alterações contratuais
Route::group(['prefix' => 'dashboard/funcionarios', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('{idFuncionario}/alteracao-contratual', ['as' => 'listAlteracaoContratualToUser', 'uses' => 'AlteracaoContratualController@index']);
    Route::get('{idFuncionario}/alteracao-contratual/new', ['as' => 'newAlteracaoContratual', 'uses' => 'AlteracaoContratualController@new']);
    Route::post('{idFuncionario}/alteracao-contratual/new', ['uses' => 'AlteracaoContratualController@store']);
    Route::get('{idFuncionario}/alteracao-contratual/view/{idAlteracao}', ['as' => 'showAlteracaoContratualToUser', 'uses' => 'AlteracaoContratualController@view']);
    Route::post('alteracao-contratual/validate', ['as' => 'validateAlteracaoContratual', 'uses' => 'AlteracaoContratualController@validateAlteracao']);
});

//Dashboard - Ponto
Route::group(['prefix' => 'dashboard/pontos', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listPontosToUser', 'uses' => 'PontoController@index']);
    Route::get('view/{idPonto}', ['as' => 'showPontoToUser', 'uses' => 'PontoController@view']);
    Route::post('view/{idPonto}', ['as' => 'sendPontos', 'uses' => 'PontoController@store']);
});

//Dashboard - Recálculo
Route::group(['prefix' => 'dashboard/recalculos', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listRecalculosToUser', 'uses' => 'RecalculoController@index']);
    Route::get('view/{idRecalculo}', ['as' => 'showRecalculoToUser', 'uses' => 'RecalculoController@view']);
    Route::get('new', ['as' => 'newRecalculo', 'uses' => 'RecalculoController@new']);
    Route::post('new', ['uses' => 'RecalculoController@store']);
    Route::post('validate', ['as' => 'validateRecalculo', 'uses' => 'RecalculoController@validateAjax']);
});

//Dashboard - Alterações
Route::group(['prefix' => 'dashboard/solicitar-alteracao', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'chooseEmpresaSolicitacaoAlteracao', 'uses' => 'AlteracaoController@index']);
    Route::get('{idEmpresa}', ['as' => 'listSolicitacoesAlteracaoToUser', 'uses' => 'AlteracaoController@list']);
    Route::post('{idEmpresa}/new', ['as' => 'newSolicitacaoAlteracao', 'uses' => 'AlteracaoController@new']);
    Route::post('{idEmpresa}/save', ['as'=>'saveSolicitacaoAlteracao', 'uses' => 'AlteracaoController@store']);
    Route::get('view/{idAlteracao}', ['as' => 'showSolicitacaoAlteracaoToUser', 'uses' => 'AlteracaoController@view']);
    Route::post('validate', ['as' => 'validateAlteracao', 'uses' => 'AlteracaoController@validateAlteracao']);
    Route::post('calculate', ['as' => 'calcularValorAlteracao', 'uses' => 'AlteracaoController@calculate']);
});

//Dashboard - Imposto de Renda
Route::group(['prefix' => 'dashboard/imposto-renda', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listImpostoRendaToUser', 'uses' => 'ImpostoRendaController@index']);
    Route::get('new', ['as' => 'newImpostoRenda', 'uses' => 'ImpostoRendaController@new']);
    Route::post('new', ['uses' => 'ImpostoRendaController@store']);
    Route::post('temp/{id?}', ['as' => 'saveIrTemp', 'uses' => 'ImpostoRendaController@saveTemp']);
    Route::get('view/{id}', ['as' => 'showImpostoRendaToUser', 'uses' => 'ImpostoRendaController@view']);
    Route::post('view/{id}', ['uses' => 'ImpostoRendaController@store']);
    Route::post('validate', ['as' => 'validateImpostoRenda', 'uses' => 'ImpostoRendaController@validateIr']);
    Route::post('validate-temp', ['as' => 'validateImpostoRendaTemp', 'uses' => 'ImpostoRendaController@validateIrTemp']);
    Route::post('validate-dependente', ['as' => 'validateIrDependente', 'uses' => 'ImpostoRendaController@validateDependente']);
});
//Dashboard - Atendimento
Route::group(['prefix' => 'dashboard/atendimento', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listAtendimentosToUser', 'uses' => 'AtendimentoController@index']);
});

//Dashboard - Chamados
Route::group(['prefix' => 'dashboard/chamados', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('new', ['as' => 'newChamado', 'uses' => 'ChamadoController@new']);
    Route::post('new', ['uses' => 'ChamadoController@store']);
    Route::get('view/{id}', ['as' => 'viewChamado', 'uses' => 'ChamadoController@view']);
    Route::post('validate', ['as' => 'validateChamado', 'uses' => 'ChamadoController@validateChamado']);
});

//Dashboard - Processo Folha
Route::group(['prefix' => 'dashboard/processamento-folha', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listProcessoFolhaToUser', 'uses' => 'ProcessoFolhaController@index']);
    Route::get('view/{idProcesso}', ['as' => 'showProcessoFolhaToUser', 'uses' => 'ProcessoFolhaController@view']);
});

//Dashboard - Anexo
Route::group(['prefix' => 'anexo', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::post('temp', ['as' => 'sendAnexoToTemp', 'uses' => 'AnexoController@sendToTemp']);
    Route::post('removeTemp', ['as' => 'removeAnexoFromTemp', 'uses' => 'AnexoController@removeFromTemp']);
});

//Dashboard - Apurações
Route::group(['prefix' => 'dashboard/apuracao', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('calendario', ['as' => 'showCalendarioImpostos', 'uses' => 'ApuracaoController@calendario']);
    Route::get('', ['as' => 'listApuracoesToUser', 'uses' => 'ApuracaoController@index']);
    Route::get('view/{idApuracao}', ['as' => 'showApuracaoToUser', 'uses' => 'ApuracaoController@view']);
    Route::post('view/{idApuracao}', ['uses' => 'ApuracaoController@update']);
    Route::post('validate/anexo', ['as' => 'validateApuracaoAnexo', 'uses' => 'ApuracaoController@validateAnexo']);
    Route::get('sem-movimento/{id}', ['as' => 'apuracaoSemMovimentacaoUser', 'uses' => 'ApuracaoController@semMovimento']);
});

//Dashboard - Documentos contábeis
Route::group(['prefix' => 'dashboard/documentos-contabeis', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listDocumentosContabeisToUser', 'uses' => 'DocumentoContabilController@index']);
    Route::get('view/{idProcesso}', ['as' => 'showDocumentoContabilToUser', 'uses' => 'DocumentoContabilController@view']);
    Route::get('view/{idProcesso}/sem-movimento', ['as' => 'flagDocumentosContabeisAsSemMovimento', 'uses' => 'DocumentoContabilController@semMovimento']);
    Route::post('view/{idProcesso}', ['uses' => 'DocumentoContabilController@update']);
    Route::get('remove/{idProcesso}/{idAnexo}', ['as'=>'removeDocumentoContabil', 'uses' => 'DocumentoContabilController@remove']);
});

//Dashboard - Agendar reunião
Route::group(['prefix' => 'dashboard/reunioes', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listReunioesToUser', 'uses' => 'ReuniaoController@index']);
    Route::post('new', ['as'=>'newReuniao', 'uses' => 'ReuniaoController@store']);
    Route::get('view/{idReuniao}', ['as' => 'showReuniaoToUser', 'uses' => 'ReuniaoController@view']);
    Route::post('view/{idReuniao}', ['uses' => 'ReuniaoController@update']);
    Route::post('validate/reuniao', ['as' => 'validateReuniao', 'uses' => 'ReuniaoController@validateAjax']);
});

//Dashboard - Balancetes
Route::group(['prefix' => 'dashboard/balancetes', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listBalancetesToUser', 'uses' => 'BalanceteController@index']);
});

//Dashboard - Contratos
Route::group(['prefix' => 'dashboard/contrato', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'showContratoToUser', 'uses' => 'ContratoController@index']);
});

//Dashboard - Certificados Digitais
Route::group(['prefix' => 'dashboard/certificados-digitais', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'listCertificadosToUser', 'uses' => 'CertificadoDigitalController@index']);
    Route::post('', ['uses' => 'CertificadoDigitalController@upload']);
    Route::get('delete/{idEmpresa}', ['as' => 'userDeleteCertificado', 'uses' => 'CertificadoDigitalController@delete']);
});

//CRON
Route::group(['namespace' => 'Dashboard'], function () {
    Route::get('abrir-apuracoes', ['uses' => 'ApuracaoController@abrirApuracoes']);
    Route::get('abrir-documentos-contabeis', ['uses' => 'DocumentoContabilController@abrirProcessos']);
    Route::get('abrir-pagamento-mensalidades', ['uses' => 'PagamentoController@updateMensalidades']);
});

Route::group(['namespace' => 'Cron', 'prefix' => 'cron'], function () {
    Route::get('daily', ['uses' => 'CronController@dailyCron']);
    Route::get('nfs', ['uses' => 'CronController@nfs2']);
    Route::get('payments', ['uses' => 'CronController@verifyPendingPayments']);
    Route::get('unread', ['uses' => 'CronController@notifyUnreadMessages']);
    Route::get('sem-movimento', ['uses' => 'CronController@changeApuracaoToSemMovimento']);
    Route::get('pending-docs', ['uses' => 'CronController@dailyCron']);
    Route::get('mensalidade/adjustmentMessage', ['uses' => 'CronController@AdjustmentInMensalidade']);
    Route::get('funcionarios/requestPontos', ['uses' => 'CronController@openPontosRequest']);
    Route::get('send/rodada-negocios', ['uses' => 'CronController@sendRodadaNegociosEmail']);
    Route::get('send/sorry', ['uses' => 'CronController@sorry']);
    Route::get('reajuste-mensalidade', ['uses' => 'CronController@reajusteMensalidade']);
});

//Dashboard - Usuário
Route::group(['prefix' => 'dashboard/usuario', 'namespace' => 'Dashboard', 'middleware' => ['auth', 'checkPayment']], function () {
    Route::get('', ['as' => 'editPerfil', 'uses' => 'UsuarioController@view']);
    Route::post('', ['uses' => 'UsuarioController@update']);
    Route::post('upload/foto', ['as' => 'uploadUsuarioFoto', 'uses' => 'UsuarioController@uploadFoto']);
});

//Dashboard - Analytics
Route::group(['prefix' => 'dashboard/analytics', 'namespace' => 'Dashboard', 'middleware' => 'auth', 'checkPayment'], function () {
    Route::get('history/balance', ['as' => 'getBalanceHistory', 'uses' => 'AnalyticsController@getBalanceHistory']);
});

//Admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'adminHome', 'uses' => 'AdminController@index']);
});

//Admin - Atendimento
Route::group(['prefix' => 'admin/atendimento', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listAtendimentosToAdmin', 'uses' => 'AtendimentoController@index']);
});

//Admin - Balancete
Route::group(['prefix' => 'admin/balancete', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listBalancetesToAdmin', 'uses' => 'BalanceteController@index']);
    Route::get('view/{id}', ['as' => 'showBalanceteToAdmin', 'uses' => 'BalanceteController@view']);
    Route::get('delete/{id}', ['as' => 'deleteBalancete', 'uses' => 'BalanceteController@delete']);
    Route::get('new/{id?}', ['as' => 'newBalancete', 'uses' => 'BalanceteController@create']);
    Route::post('new/{id?}', ['uses' => 'BalanceteController@store']);
    Route::get('history/{id?}', ['as' => 'getBalanceteHistory', 'uses' => 'BalanceteController@history']);
    Route::post('validate', ['as' => 'validateBalancete', 'uses' => 'BalanceteController@validateBalancete']);
});

//Admin - Abertura de Empresa
Route::group(['prefix' => 'admin/abertura-empresa', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listAberturaEmpresaToAdmin', 'uses' => 'AberturaEmpresaController@index']);
    Route::get('view/{id}', ['as' => 'showAberturaEmpresaToAdmin', 'uses' => 'AberturaEmpresaController@view']);
    Route::get('finish/{id}', ['as' => 'createEmpresaFromAberturaEmpresa', 'uses' => 'AberturaEmpresaController@createEmpresa']);
    Route::get('change-status/{id}/{status}', ['as' => 'changeAberturaEmpresaStatus', 'uses' => 'AberturaEmpresaController@changeStatus']);
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

//Admin -Décimo terceiro
Route::group(['prefix' => 'admin/decimo-terceiro', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listDecimoTerceiroToAdmin', 'uses' => 'DecimoTerceiroController@index']);
    Route::get('view/{id}', ['as' => 'showDecimoTerceiroToAdmin', 'uses' => 'DecimoTerceiroController@view']);
    Route::post('view/{id}', ['uses' => 'DecimoTerceiroController@update']);
    Route::get('new', ['as' => 'newDecimoTerceiro', 'uses' => 'DecimoTerceiroController@new']);
    Route::post('new', ['uses' => 'DecimoTerceiroController@store']);
    Route::post('validate', ['as' => 'validateDecimoTerceiro', 'uses' => 'DecimoTerceiroController@validateDecimoTerceiro']);
});

//Admin - Empresa
Route::group(['prefix' => 'admin/empresas', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listEmpresaToAdmin', 'uses' => 'EmpresaController@index']);
    Route::get('view/{id}', ['as' => 'showEmpresaToAdmin', 'uses' => 'EmpresaController@view']);
    Route::get('view/{id}/toggle-request/{doc}', ['as' => 'toggleRequestDocEmpresa', 'uses' => 'EmpresaController@toggleRequestDoc']);
    Route::get('view/{id}/warn-pending-docs', ['as' => 'warnUserPendingDocsInEmpresa', 'uses' => 'EmpresaController@warnUserPendingDocs']);
    Route::get('cnaes/{id}', ['as' => 'getCnaesSemFormatacao', 'uses' => 'EmpresaController@cnaes']);

    Route::post('activate/scheduled/{id}', ['as' => 'scheduleEmpresaActivation', 'uses' => 'EmpresaController@ativacaoProgramada']);
    Route::get('activate/{idEmpresa}', ['as' => 'activateEmpresa', 'uses' => 'EmpresaController@ativar']);
    Route::get('deactivate/{idEmpresa}', ['as' => 'deactivateEmpresa', 'uses' => 'EmpresaController@desativar']);
    Route::get('activate/cancel/{idEmpresa}', ['as' => 'unscheduleEmpresaActivation', 'uses' => 'EmpresaController@cancelarAtivacao']);
    Route::get('{idEmpresa}/funcionarios/view/{idFuncionario}', ['as' => 'showFuncionarioToAdmin', 'uses' => 'FuncionarioController@view']);
    Route::get('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['as' => 'listDocumentosFuncionarioToAdmin', 'uses' => 'FuncionarioDocumentoController@index']);
    Route::post('{idEmpresa}/funcionarios/{idFuncionario}/documentos', ['uses' => 'FuncionarioDocumentoController@store']);
    Route::get('{idEmpresa}/funcionarios/{idFuncionario}/ativar', ['as' => 'activateFuncionario', 'uses' => 'FuncionarioController@activate']);
});

//Admin - Analytics
Route::group(['prefix' => 'admin/analytics', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('users/registered', ['as' => 'getRegisteredUsersHistory', 'uses' => 'AdminController@getRegisteredUsersHistory']);
    Route::get('history/payments', ['as' => 'getPaymentHistory', 'uses' => 'AdminController@getPaymentHistory']);
    Route::get('history/new', ['as' => 'getHistorySeries', 'uses' => 'AdminController@getHistorySeries']);
    Route::get('history/balance/{idEmpresa}', ['as' => 'getBalanceHistoryOfCompany', 'uses' => 'AdminController@getBalanceHistoryOfCompany']);

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
    Route::get('change-status/{id}/{status}', ['as' => 'changeAlteracaoStatus', 'uses' => 'AlteracaoController@changeStatus']);
});

//Admin - Recálculos
Route::group(['prefix' => 'admin/recalculos', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listRecalculosToAdmin', 'uses' => 'RecalculoController@index']);
    Route::get('view/{idRecalculo}', ['as' => 'showRecalculoToAdmin', 'uses' => 'RecalculoController@view']);
    Route::post('view/{idRecalculo}', ['uses' => 'RecalculoController@update']);
    Route::post('view/{idRecalculo}/upload/guia', ['uses' => 'RecalculoController@uploadGuia']);
    Route::post('validate/guia', ['as' => 'validateGuia', 'uses' => 'RecalculoController@validateGuia']);
});

//Admin - Reunião
Route::group(['prefix' => 'admin/reunioes', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listReunioesToAdmin', 'uses' => 'ReuniaoController@index']);
    Route::get('view/{idReuniao}', ['as' => 'showReuniaoToAdmin', 'uses' => 'ReuniaoController@view']);
    Route::post('view/{idReuniao}', ['uses' => 'ReuniaoController@update']);
    Route::post('validate/reuniao', ['as' => 'validateReuniaoAdmin', 'uses' => 'ReuniaoController@validateAjax']);
});

//Admin - Apurações
Route::group(['prefix' => 'admin/apuracao', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listApuracoesToAdmin', 'uses' => 'ApuracaoController@index']);
    Route::get('view/{idApuracao}', ['as' => 'showApuracaoToAdmin', 'uses' => 'ApuracaoController@view']);
    Route::post('view/{idApuracao}', ['uses' => 'ApuracaoController@update']);
    Route::post('view/{idApuracao}/upload/guia', ['uses' => 'ApuracaoController@uploadGuia']);
    Route::post('validate/guia', ['as' => 'validateGuia', 'uses' => 'ApuracaoController@validateGuia']);
    Route::get('view/{idApuracao}/download-zip', ['as' => 'downloadZipApuracao', 'uses' => 'ApuracaoController@downloadZip']);
});

//Admin - Imposto de Renda
Route::group(['prefix' => 'admin/imposto-renda', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listImpostoRendaToAdmin', 'uses' => 'ImpostoRendaController@index']);
    Route::get('view/{id}', ['as' => 'showImpostoRendaToAdmin', 'uses' => 'ImpostoRendaController@view']);
    Route::post('view/{id}', ['uses' => 'ImpostoRendaController@update']);
    Route::post('view/{id}/upload', ['uses' => 'ImpostoRendaController@upload']);
    Route::post('validate/file', ['as' => 'validateFile', 'uses' => 'ImpostoRendaController@validateFile']);
});

//Admin - Usuários
Route::group(['prefix' => 'admin/usuarios', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listUsuariosToAdmin', 'uses' => 'UsuarioController@index']);
    Route::get('view/{idUsuario}', ['as' => 'showUsuarioToAdmin', 'uses' => 'UsuarioController@view']);
    Route::get('kill/{id}', ['as' => 'killUsuario', 'uses' => 'UsuarioController@kill']);
    Route::get('disable/{id}', ['as' => 'disableUsuario', 'uses' => 'UsuarioController@disable']);
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
    Route::get('view/{idProcesso}/download-zip', ['as' => 'downloadZipDocumentosContabeis', 'uses' => 'DocumentoContabilController@downloadZip']);
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
    Route::get('finish/{idPonto}', ['as' => 'finishPontos', 'uses' => 'PontoController@finish']);
});

//Admin - Chat
Route::group(['prefix' => 'admin/chat', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listChatToAdmin', 'uses' => 'ChatController@index']);
    Route::get('view/{idChat}', ['as' => 'showChatToAdmin', 'uses' => 'ChatController@view']);
    Route::get('activate/{idChat}', ['as' => 'ativarChat', 'uses' => 'ChatController@activate']);
    Route::get('terminate/{idChat}', ['as' => 'finalizarChat', 'uses' => 'ChatController@terminate']);
});

//Admin - Notícias
Route::group(['prefix' => 'admin/noticias', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listNoticiasToAdmin', 'uses' => 'NoticiaController@index']);
    Route::get('new', ['as' => 'newNoticia', 'uses' => 'NoticiaController@new']);
    Route::get('view/{id}', ['as' => 'showNoticiaToAdmin', 'uses' => 'NoticiaController@view']);
    Route::post('view/{id}', ['uses' => 'NoticiaController@update']);
    Route::post('new', ['uses' => 'NoticiaController@store']);
    Route::post('validate', ['as' => 'validateNoticia', 'uses' => 'NoticiaController@validateNoticia']);
});

//Admin - Cadastro Alteração
Route::group(['prefix' => 'admin/cadastros/alteracao', 'namespace' => 'Cadastro', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listCadastroAlteracao', 'uses' => 'TipoAlteracaoController@index']);
    Route::get('new', ['as' => 'newTipoAlteracao', 'uses' => 'TipoAlteracaoController@new']);
    Route::post('new', ['uses' => 'TipoAlteracaoController@store']);
    Route::get('view/{id}', ['as' => 'viewTipoAlteracao', 'uses' => 'TipoAlteracaoController@view']);
    Route::post('view/{id}', ['uses' => 'TipoAlteracaoController@update']);
    Route::post('validate', ['as' => 'validateTipoAlteracao', 'uses' => 'TipoAlteracaoController@validateTipoAlteracao']);
});

//Admin - Cadastro Recálculo
Route::group(['prefix' => 'admin/cadastros/recalculo', 'namespace' => 'Cadastro', 'middleware' => 'admin'], function () {
    Route::get('', ['as' => 'listCadastroRecalculo', 'uses' => 'TipoRecalculoController@index']);
    Route::get('new', ['as' => 'newTipoRecalculo', 'uses' => 'TipoRecalculoController@new']);
    Route::post('new', ['uses' => 'TipoRecalculoController@store']);
    Route::get('view/{id}', ['as' => 'viewTipoRecalculo', 'uses' => 'TipoRecalculoController@view']);
    Route::post('view/{id}', ['uses' => 'TipoRecalculoController@update']);
    Route::post('validate', ['as' => 'validateTipoRecalculo', 'uses' => 'TipoRecalculoController@validateAjax']);
});

//Ajax
Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
    Route::post('cnae/search/code', ['as' => 'searchCnaeByCode', 'uses' => 'AjaxController@searchCnaeByCode']);
    Route::post('cnae/search/description', ['as' => 'searchCnaeByDescription', 'uses' => 'AjaxController@searchCnaeByDescription']);
    Route::post('messages/send', ['as' => 'sendMessageAjax', 'uses' => 'AjaxController@sendMessage']);
    Route::post('annotations/send', ['as' => 'sendAnnotationAjax', 'uses' => 'AjaxController@sendAnnotation']);
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
    Route::post('files/upload/temp', ['as' => 'uploadTempFile', 'uses' => 'AjaxController@uploadTempFile']);
    Route::post('images/upload', ['as' => 'uploadImage', 'uses' => 'AjaxController@uploadImage']);
});

//Pagseguro
Route::group(['namespace' => 'Pagseguro'], function () {
    Route::post('notifications', ['as' => 'pagseguroNotification', 'uses' => 'PagseguroController@notifications']);
    Route::get('verificar-pagamentos', ['uses' => 'PagseguroController@checkPayments']);
});
