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

class AlteracaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $tiposAlteracao = TipoAlteracao::orderBy('descricao')->get();

        $alteracoesPendentes = Auth::user()->alteracoes()
            ->whereIn('status', ['Pendente', 'Atencao'])
            ->orderBy('created_at')
            ->get();

        $alteracoesConcluidas = Auth::user()->alteracoes()
            ->whereIn('status',['Concluído', 'Cancelado'])
            ->orderBy('created_at')
            ->get();
        return view('dashboard.alteracao.index', compact("tiposAlteracao", 'alteracoesPendentes', 'alteracoesConcluidas'));
    }

    public function new($idTipoAlteracao)
    {
        $tipoAlteracao = TipoAlteracao::find($idTipoAlteracao);
        $empresas = Auth::user()->empresas()->orderBy('nome_fantasia', 'asc')->get();
        return view('dashboard.alteracao.new.index', compact('tipoAlteracao', 'empresas'));
    }

    public function view($idAlteracao)
    {
        $alteracao = Auth::user()->alteracoes()->find($idAlteracao);
        return view('dashboard.alteracao.view.index', compact('alteracao'));
    }

    public function store(Request $request)
    {
        $this->validate($request, AlteracaoValidation::getRules(), [], AlteracaoValidation::getNiceNames());
        if (CreateSolicitacaoAlteracao::handle($request)) {
            return redirect()->route('listSolicitacoesAlteracaoToUser')->with('successAlert', 'Sua solicitação foi aberta com sucesso, você receberá uma notificação assim que respondermos :)');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function validateAlteracao(Request $request)
    {
        $this->validate($request, AlteracaoValidation::getRules(), [], AlteracaoValidation::getNiceNames());
    }

}
