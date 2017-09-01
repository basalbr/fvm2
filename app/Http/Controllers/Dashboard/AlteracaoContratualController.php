<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

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

    public function index($idFuncionario)
    {
        $funcionario = Auth::user()->funcionarios()->findOrFail($idFuncionario);
        $alteracoes = AlteracaoContratual::join('funcionario','funcionario.id','=','alteracao_contratual.id_funcionario')
            ->join('empresa','empresa.id','=','funcionario.id_empresa')
            ->join('usuario', 'usuario.id','=','empresa.id_usuario')
            ->where('usuario.id',Auth::user()->id)
            ->select('alteracao_contratual.*')
            ->orderBy('alteracao_contratual.data_alteracao','desc')
            ->get();
        return view('dashboard.alteracao_contratual.index', compact('funcionario','alteracoes'));
    }


    public function new($idFuncionario)
    {
        $funcionario = Auth::user()->funcionarios()->findOrFail($idFuncionario);
        $contrato = $funcionario->contratos()->latest()->first();
        $tiposAlteracoes = TipoAlteracaoContratual::orderBy('descricao')->get();
        $dow = Config::getDaysOfWeek();
        return view('dashboard.alteracao_contratual.new.index', compact('funcionario','tiposAlteracoes','dow', 'contrato'));
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

    public function view($idFuncionario, $idAlteracao)
    {
        /* @var Funcionario $funcionario */
        $funcionario = Auth::user()->funcionarios()->findOrFail($idFuncionario);
        $alteracao = $funcionario->alteracoes()->findOrFail($idAlteracao);
        $tiposAlteracoes = TipoAlteracaoContratual::orderBy('descricao')->get();
        $dow = Config::getDaysOfWeek();
        return view('dashboard.alteracao_contratual.view.index', compact('funcionario', 'alteracao', 'dow', 'tiposAlteracoes'));
    }

    public function validateAlteracao(Request $request)
    {
        $request->merge(['id_funcionario' => 1]);
        $this->validate($request, AlteracaoContratualValidation::getRules(), [], AlteracaoContratualValidation::getNiceNames());
    }

}
