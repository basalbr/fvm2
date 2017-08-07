<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Alteracao;
use App\Models\Apuracao;
use App\Models\OrdemPagamento;
use App\Models\ProcessoDocumentoContabil;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $pagamentosPendentes = OrdemPagamento::where('status', '!=', 'Paga')->where('status', '!=', 'Disponível')->count();
        $alteracoesPendentes = Alteracao::join('ordem_pagamento', 'ordem_pagamento.id_referencia', '=','alteracao.id')
            ->where('alteracao.status', 'Pendente')
            ->where('ordem_pagamento.referencia', '=', (new Alteracao)->getTable())
            ->whereIn('ordem_pagamento.status',['Disponível','Paga'])
            ->count();
        $apuracoesPendentes = Apuracao::whereNotIn('apuracao.status', ['concluido', 'sem_movimento'])
            ->count();
        $processosPendentes = ProcessoDocumentoContabil::where('processo_documento_contabil.status', '!=', 'concluido')
            ->where('processo_documento_contabil.status', '!=', 'sem_movimento')->count();
        return view('admin.index', compact('pagamentosPendentes', 'apuracoesPendentes', 'processosPendentes', 'alteracoesPendentes'));
    }


}
