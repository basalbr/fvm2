<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\AlteracaoContratual;
use App\Models\Config;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\TipoAlteracaoContratual;
use App\Services\CreateAlteracaoContratual;
use App\Services\SendPontos;
use App\Validation\AlteracaoContratualValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AlteracaoContratualController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $pendentes = AlteracaoContratual::whereIn('status',['pendente'])->orderBy('created_at', 'desc')->get();
        $concluidas = AlteracaoContratual::whereIn('status',['concluido','cancelado'])->orderBy('created_at', 'desc')->get();
        return view('admin.alteracao_contratual.index', compact('pendentes','concluidas'));
    }


    public function new($idFuncionario)
    {
        $funcionario = Auth::user()->funcionarios()->findOrFail($idFuncionario);
        $contrato = $funcionario->contratos()->latest()->first();
        $tiposAlteracoes = TipoAlteracaoContratual::orderBy('descricao')->get();
        $dow = Config::getDaysOfWeek();
        return view('admin.alteracao_contratual.new.index', compact('funcionario','tiposAlteracoes','dow', 'contrato'));
    }

    public function store(Request $request, $idFuncionario)
    {

        $request->merge(['id_funcionario' => $idFuncionario]);

        $this->validate($request, AlteracaoContratualValidation::getRules(), [], AlteracaoContratualValidation::getNiceNames());
        if (CreateAlteracaoContratual::handle($request, $idFuncionario)) {

            return redirect()->route('listAlteracaoContratualToUser', $idFuncionario)->with('successAlert', 'Alteração solicitada com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function view($idAlteracao)
    {
        $alteracao = AlteracaoContratual::findOrFail($idAlteracao);
        $funcionario = $alteracao->funcionario;
        $tiposAlteracoes = TipoAlteracaoContratual::orderBy('descricao')->get();
        $dow = Config::getDaysOfWeek();
        return view('admin.alteracao_contratual.view.index', compact('funcionario', 'alteracao', 'dow', 'tiposAlteracoes'));
    }

    public function validateAlteracao(Request $request)
    {
        $request->merge(['id_funcionario' => 1]);
        $this->validate($request, AlteracaoContratualValidation::getRules(), [], AlteracaoContratualValidation::getNiceNames());
    }

}
