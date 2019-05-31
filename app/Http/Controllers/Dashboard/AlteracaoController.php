<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */
namespace App\Http\Controllers\Dashboard;

use App\Models\Alteracao;
use App\Models\TipoAlteracao;
use App\Services\CreateSolicitacaoAlteracao;
use App\Validation\AlteracaoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AlteracaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $empresas = Auth::user()->empresas()->orderBy('razao_social')->get();
        return view('dashboard.alteracao.index', compact('empresas'));
    }

    public function list($idEmpresa)
    {
        $tiposAlteracao = TipoAlteracao::orderBy('descricao')->get();

        $alteracoesPendentes = Auth::user()->alteracoes()
            ->where('id_empresa', $idEmpresa)
            ->whereNotIn('status', ['Cancelado', 'Concluído', 'cancelado', 'concluido'])
            ->orderBy('created_at')
            ->get();

        $alteracoesConcluidas = Auth::user()->alteracoes()
            ->where('id_empresa', $idEmpresa)
            ->whereIn('status', ['Cancelado', 'Concluído', 'cancelado', 'concluido'])
            ->orderBy('created_at')
            ->get();

        return view('dashboard.alteracao.list', compact("tiposAlteracao", 'alteracoesPendentes', 'alteracoesConcluidas', 'idEmpresa'));
    }

    public function new(Request $request, $idEmpresa)
    {
        $tipos = TipoAlteracao::whereIn('id', $request->get('itens'))->get();
        $empresa = Auth::user()->empresas()->findOrFail($idEmpresa);
        return view('dashboard.alteracao.new.index', compact('tipos', 'empresa'));
    }

    public function view($idAlteracao)
    {
        $step = 1;
        $alteracao = Auth::user()->alteracoes()->findOrFail($idAlteracao);
        return view('dashboard.alteracao.view.index', compact('alteracao', 'step'));
    }

    public function store(Request $request, $idEmpresa)
    {
        if (CreateSolicitacaoAlteracao::handle($request, $idEmpresa)) {
            return redirect()->route('listSolicitacoesAlteracaoToUser', $idEmpresa)->with('successAlert', 'Sua solicitação foi aberta com sucesso, você receberá uma notificação assim que respondermos :)');
        }
        return Redirect::back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function validateAlteracao(Request $request)
    {
        $this->validate($request, AlteracaoValidation::getRules(), [], AlteracaoValidation::getNiceNames());
    }

    public function calculate(Request $request)
    {
        return $request->has('itens') ? response()->json(Alteracao::calculaValorAlteracaoAjax($request->get('itens'))) : response()->json(0.0);
    }

}