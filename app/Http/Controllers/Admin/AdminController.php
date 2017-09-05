<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\AberturaEmpresa;
use App\Models\Alteracao;
use App\Models\AlteracaoContratual;
use App\Models\Apuracao;
use App\Models\Empresa;
use App\Models\OrdemPagamento;
use App\Models\ProcessoDocumentoContabil;
use App\Models\Usuario;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Composer\CaBundle\CaBundle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $pagamentosPendentes = OrdemPagamento::where('status', '!=', 'Paga')->where('status', '!=', 'Disponível')->count();
        $alteracoesPendentes = Alteracao::join('ordem_pagamento', 'ordem_pagamento.id_referencia', '=', 'alteracao.id')
            ->where('alteracao.status', 'Pendente')
            ->where('ordem_pagamento.referencia', '=', (new Alteracao)->getTable())
            ->whereIn('ordem_pagamento.status', ['Disponível', 'Paga'])
            ->count();
        $apuracoesPendentes = Apuracao::whereNotIn('apuracao.status', ['concluido', 'sem_movimento'])
            ->count();
        $processosPendentes = ProcessoDocumentoContabil::where('processo_documento_contabil.status', '!=', 'concluido')
            ->where('processo_documento_contabil.status', '!=', 'sem_movimento')->count();
        return view('admin.index', compact('pagamentosPendentes', 'apuracoesPendentes', 'processosPendentes', 'alteracoesPendentes'));
    }

    public function getRegisteredUsersHistory()
    {
        $initialDate = (new Carbon('first day of 6 months ago'))->format('Y-m');
//        return $initialDate;
        DB::enableQueryLog();
        $usuarios = Usuario::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=',$initialDate)->groupBy(DB::Raw('YEAR(created_at)'), DB::Raw("MONTH(created_at) DESC"), DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"))->select(DB::Raw("COUNT(*) as qtde, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(6)->get()->toArray();
        $usuariosData = [];
        $empresas = Empresa::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=',$initialDate)->groupBy(DB::Raw('YEAR(created_at)'), DB::Raw("MONTH(created_at) DESC"), DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"))->select(DB::Raw("COUNT(*) as qtde, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(6)->get()->toArray();
        $empresasData = [];
        $aberturas = AberturaEmpresa::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=',$initialDate)->groupBy(DB::Raw('YEAR(created_at)'), DB::Raw("MONTH(created_at) DESC"), DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"))->select(DB::Raw("COUNT(*) as qtde, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(6)->get()->toArray();
        $aberturasData = [];
//        $alteracoes = Alteracao::groupBy(DB::Raw('YEAR(created_at)'), DB::Raw("MONTH(created_at)"))->orderBy('created_at', 'desc')->select(DB::Raw("COUNT(*) as qtde, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(6)->get()->toArray();
//        $alteracoesData = [];
        foreach (array_reverse($usuarios) as $usuario) {
            $usuariosData[] = [Carbon::createFromFormat('Y-n-d', $usuario['ano'] . '-' . $usuario['mes'] . '-01')->format('U') * 1000, (int) $usuario['qtde']];
        }
        foreach (array_reverse($empresas) as $empresa) {
            $empresasData[] = [Carbon::createFromFormat('Y-n-d', $empresa['ano'] . '-' . $empresa['mes'] . '-01')->format('U') * 1000, (int) $empresa['qtde']];
        }
        foreach (array_reverse($aberturas) as $abertura) {
            $aberturasData[] = [Carbon::createFromFormat('Y-n-d', $abertura['ano'] . '-' . $abertura['mes'] . '-01')->format('U') * 1000, (int) $abertura['qtde']];
        }
//        foreach (array_reverse($alteracoes) as $alteracao) {
//            $alteracoesData[] = [Carbon::createFromFormat('Y-n-d', $abertura['ano'] . '-' . $alteracao['mes'] . '-01')->format('U') * 1000, $alteracao['qtde']];
//        }
        return response()->json([['name'=>'Novos usuários', 'data'=>$usuariosData], ['name'=>'Novas aberturas de empresa', 'data'=>$aberturasData], ['name'=>'Novas empresas', 'data'=>$empresasData]]);
    }

    public function getNewEmpresasHistory($months)
    {
        $initialDate = (new Carbon('first day of ' . $months . ' months ago'))->format('Y-m-d');
        $empresa = Empresa::groupBy(DB::Raw('YEAR(created_at)'), DB::Raw("MONTH(created_at)"))->orderBy('created_at', 'desc')->where('created_at', '>', $initialDate)->select(DB::Raw("COUNT(*) as qtde, MONTH(created_at) as mes"))->limit(6)->get()->toArray();
        return array_reverse($empresa);
    }

    public function getNewAberturaEmpresaHistory($months)
    {
        $initialDate = (new Carbon('first day of ' . $months . ' months ago'))->format('Y-m-d');
        $aberturaEmpresas = AberturaEmpresa::groupBy(DB::Raw('YEAR(created_at)'), DB::Raw("MONTH(created_at)"))->orderBy('created_at', 'desc')->where('created_at', '>', $initialDate)->select(DB::Raw("COUNT(*) as qtde, MONTH(created_at) as mes"))->limit(6)->get()->toArray();
        return array_reverse($aberturaEmpresas);
    }

    public function getLastMonths($qtd)
    {
        $months = [];
        for ($i = 0; $i < $qtd; $i++) {
            if ($i == 0) {
                $months[] = (Carbon::today())->format('n');
            } else {
                $months[] = (new Carbon('first day of ' . $i . 'months ago'))->format('n');
            }
        }
        return $months;
    }

}
