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
use App\Models\Chamado;
use App\Models\Empresa;
use App\Models\ImpostoRenda;
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
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        $notificacoes = \Auth::user()->notifications();
        $notificacoes = $this->filterNotifications($notificacoes, $request);
        $notificacoes = $notificacoes->paginate(10);
        $pagamentosPendentes = OrdemPagamento::where('status', '!=', 'Paga')->where('status', '!=', 'Disponível')->count();
        $alteracoesPendentes = Alteracao::join('ordem_pagamento', 'ordem_pagamento.id_referencia', '=', 'alteracao.id')
            ->whereNotIn('alteracao.status', ['concluido', 'cancelado'])
            ->where('ordem_pagamento.referencia', '=', (new Alteracao)->getTable())
            ->whereIn('ordem_pagamento.status', ['Disponível', 'Paga'])
            ->count();
        $aberturasPendentes = AberturaEmpresa::join('ordem_pagamento', 'ordem_pagamento.id_referencia', '=', 'abertura_empresa.id')
            ->whereNotIn('abertura_empresa.status', ['concluido', 'cancelado'])
            ->where('ordem_pagamento.referencia', '=', (new AberturaEmpresa)->getTable())
            ->whereIn('ordem_pagamento.status', ['Disponível', 'Paga'])
            ->count();
        $irsPendentes = ImpostoRenda::join('ordem_pagamento', 'ordem_pagamento.id_referencia', '=', 'imposto_renda.id')
            ->whereNotIn('imposto_renda.status', ['concluido', 'cancelado'])
            ->where('ordem_pagamento.referencia', '=', (new ImpostoRenda)->getTable())
            ->whereIn('ordem_pagamento.status', ['Disponível', 'Paga'])
            ->count();
        $apuracoesPendentes = Apuracao::whereNotIn('apuracao.status', ['concluido', 'sem_movimento', 'cancelado'])
            ->count();
        $processosPendentes = ProcessoDocumentoContabil::where('processo_documento_contabil.status', '!=', 'concluido')
            ->where('processo_documento_contabil.status', '!=', 'sem_movimento')->count();
        $chamadosPendentes = Chamado::whereNotIn('status', ['concluido'])->count();
        return view('admin.index', compact('chamadosPendentes','irsPendentes','aberturasPendentes','pagamentosPendentes', 'apuracoesPendentes', 'processosPendentes', 'alteracoesPendentes', 'notificacoes'));
    }

    public function getRegisteredUsersHistory()
    {
        $initialDate = (new Carbon('first day of 12 months ago'))->format('Y-m');
//        return $initialDate;
        DB::enableQueryLog();
        $usuarios = Usuario::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=', $initialDate)->groupBy(DB::Raw('YEAR(created_at) DESC'), DB::Raw("MONTH(created_at) DESC"), DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"))->select(DB::Raw("COUNT(*) as qtde, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(12)->get()->toArray();
        $usuariosData = [];
        $empresas = Empresa::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=', $initialDate)->groupBy(DB::Raw('YEAR(created_at) DESC'), DB::Raw("MONTH(created_at) DESC "), DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"))->select(DB::Raw("COUNT(*) as qtde, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(12)->get()->toArray();
        $empresasData = [];
        $aberturas = AberturaEmpresa::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=', $initialDate)->groupBy(DB::Raw('YEAR(created_at) DESC'), DB::Raw("MONTH(created_at) DESC"), DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"))->select(DB::Raw("COUNT(*) as qtde, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(12)->get()->toArray();
        $aberturasData = [];
//        $alteracoes = Alteracao::groupBy(DB::Raw('YEAR(created_at)'), DB::Raw("MONTH(created_at)"))->orderBy('created_at', 'desc')->select(DB::Raw("COUNT(*) as qtde, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(6)->get()->toArray();
//        $alteracoesData = [];
        foreach (array_reverse($usuarios) as $usuario) {
            $usuariosData[] = [Carbon::createFromFormat('Y-n-d', $usuario['ano'] . '-' . $usuario['mes'] . '-01')->format('U') * 1000, (int)$usuario['qtde']];
        }
        foreach (array_reverse($empresas) as $empresa) {
            $empresasData[] = [Carbon::createFromFormat('Y-n-d', $empresa['ano'] . '-' . $empresa['mes'] . '-01')->format('U') * 1000, (int)$empresa['qtde']];
        }
        foreach (array_reverse($aberturas) as $abertura) {
            $aberturasData[] = [Carbon::createFromFormat('Y-n-d', $abertura['ano'] . '-' . $abertura['mes'] . '-01')->format('U') * 1000, (int)$abertura['qtde']];
        }
//        foreach (array_reverse($alteracoes) as $alteracao) {
//            $alteracoesData[] = [Carbon::createFromFormat('Y-n-d', $abertura['ano'] . '-' . $alteracao['mes'] . '-01')->format('U') * 1000, $alteracao['qtde']];
//        }
        return response()->json([['name' => 'Novos usuários', 'data' => $usuariosData], ['name' => 'Novas aberturas de empresa', 'data' => $aberturasData], ['name' => 'Novas empresas', 'data' => $empresasData]]);
    }

    public function getPaymentHistory()
    {
        $initialDate = (new Carbon('first day of 12 months ago'))->format('Y-m');
        DB::enableQueryLog();
        $pagamentosAbertos = OrdemPagamento::where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=', $initialDate)->groupBy(DB::Raw('YEAR(created_at) DESC'), DB::Raw("MONTH(created_at) DESC"), DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"))->select(DB::Raw("SUM(valor) as valor, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(12)->get()->toArray();
        $pagamentosAbertosData = [];
        $pagamentosPagos = OrdemPagamento::where('status', 'Paga')->where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=', $initialDate)->groupBy(DB::Raw('YEAR(created_at) DESC'), DB::Raw("MONTH(created_at) DESC "), DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"))->select(DB::Raw("SUM(valor) as valor, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(12)->get()->toArray();
        $pagamentosPagosData = [];
        $mensalidades = OrdemPagamento::where('status','Paga')->where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=', $initialDate)->groupBy(DB::Raw('YEAR(created_at) DESC'), DB::Raw("MONTH(created_at) DESC"), DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"))->where('referencia', 'mensalidade')->select(DB::Raw("SUM(valor) as valor, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(12)->get()->toArray();
        $mensalidadesData = [];
        $aberturas = OrdemPagamento::where('referencia', 'abertura_empresa')->where('status', 'Paga')->where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=', $initialDate)->groupBy(DB::Raw('YEAR(created_at) DESC'), DB::Raw("MONTH(created_at) DESC "), DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"))->select(DB::Raw("SUM(valor) as valor, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(12)->get()->toArray();
        $aberturasData = [];
        $alteracoes = OrdemPagamento::where('referencia', 'alteracao')->where('status', 'Paga')->where(DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"), '>=', $initialDate)->groupBy(DB::Raw('YEAR(created_at) DESC'), DB::Raw("MONTH(created_at) DESC "), DB::Raw("DATE_FORMAT(created_at,'%Y-%m')"))->select(DB::Raw("SUM(valor) as valor, MONTH(created_at) as mes, YEAR(created_at) as ano"))->limit(12)->get()->toArray();
        $alteracoesData = [];
        foreach (array_reverse($pagamentosAbertos) as $pagamento) {
            $pagamentosAbertosData[] = [Carbon::createFromFormat('Y-n-d', $pagamento['ano'] . '-' . $pagamento['mes'] . '-01')->format('U') * 1000, (float)$pagamento['valor']];
        }
        foreach (array_reverse($pagamentosPagos) as $pagamento) {
            $pagamentosPagosData[] = [Carbon::createFromFormat('Y-n-d', $pagamento['ano'] . '-' . $pagamento['mes'] . '-01')->format('U') * 1000, (float)$pagamento['valor']];
        }
        foreach (array_reverse($aberturas) as $pagamento) {
            $aberturasData[] = [Carbon::createFromFormat('Y-n-d', $pagamento['ano'] . '-' . $pagamento['mes'] . '-01')->format('U') * 1000, (float)$pagamento['valor']];
        }
        foreach (array_reverse($mensalidades) as $pagamento) {
            $mensalidadesData[] = [Carbon::createFromFormat('Y-n-d', $pagamento['ano'] . '-' . $pagamento['mes'] . '-01')->format('U') * 1000, (float)$pagamento['valor']];
        }
        foreach (array_reverse($alteracoes) as $pagamento) {
            $alteracoesData[] = [Carbon::createFromFormat('Y-n-d', $pagamento['ano'] . '-' . $pagamento['mes'] . '-01')->format('U') * 1000, (float)$pagamento['valor']];
        }
        return response()->json([
            ['name' => 'Cobranças abertas', 'data' => $pagamentosAbertosData, 'color' => '#E0E0E0'],
            ['name' => 'Cobranças pagas', 'data' => $pagamentosPagosData, 'color' => '#42a5f5'],
            ['name' => 'Mensalidades pagas', 'data' => $mensalidadesData, 'color'=>'#ffa500', 'grouping'=>true],
            ['name' => 'Aberturas pagas', 'data' => $aberturasData, 'grouping'=>true],
            ['name' => 'Alteracoes pagas', 'data' => $alteracoesData, 'grouping'=>true],
        ]);
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

    public function getBalanceHistoryOfCompany($idEmpresa)
    {
        $initialDate = (new Carbon('first day of 12 months ago'))->format('Y-m');
        DB::enableQueryLog();
        $empresa = Empresa::findOrFail($idEmpresa);
        $companyData = [];
        $balancetes = $empresa->balancetes()->where('exercicio', '!=', null)->orderBy('exercicio', 'desc')->get()->reverse();
        if ($balancetes) {
            $receitasData = [];
            $despesasData = [];
//            $resultData = [];
            foreach ($balancetes as $balancete) {
                $receitasData[] = ['x' => $balancete->exercicio->format('U') * 1000, 'y' => ($balancete->receitas - 0), 'name' => 'Receitas', 'dataLabels' => ['format' => '{y}C', 'color' => '#3CBC3C']];
                $despesasData[] = ['x' => $balancete->exercicio->format('U') * 1000, 'y' => ($balancete->despesas - 0), 'color' => '#FF5050', 'name' => 'Despesas', 'dataLabels' => ['format' => '{y}D', 'color' => '#FF5050']];
//                    $resultData[] = ['x' => $balancete->exercicio->format('U') * 1000, 'y' => ($balancete->receitas > $balancete->despesas ? $balancete->receitas - $balancete->despesas : $balancete->despesas - $balancete->receitas), 'name' => 'Resultado Final', 'type' => 'line'];
            }
            $companyData[] = ['data' => $receitasData, 'name' => $empresa->razao_social, 'type' => 'area', 'wdataLabels' => ['enabled' => true, 'style' => ['fontWeight' => 'normal']]];
            $companyData[] = ['data' => $despesasData, 'name' => $empresa->razao_social, 'linkedTo' => ':previous', 'type' => 'area', 'color' => '#ff0000', 'dataLabels' => ['enabled' => true, 'style' => ['fontWeight' => 'normal']]];
//                $companyData[] = ['data' => $resultData, 'name' => $empresa->razao_social, 'linkedTo' => ':previous', 'type' => 'line'];


        }
        return response()->json($companyData);
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function filterNotifications($query, $request)
    {
        if($request->get('read')){
            switch ($request->get('read')) {
                case 'unread':
                    $query->where('read_at', null);
                    break;
                case 'read':
                    $query->where('read_at','!=', null);
                    break;
            }
        }
        return $query;
    }

}