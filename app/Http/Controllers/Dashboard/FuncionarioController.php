<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\CategoriaContratoTrabalho;
use App\Models\CondicaoEstrangeiro;
use App\Models\Deficiencia;
use App\Models\EstadoCivil;
use App\Models\GrauInstrucao;
use App\Models\GrupoSanguineo;
use App\Models\Raca;
use App\Models\Sexo;
use App\Models\SituacaoSeguroDesemprego;
use App\Models\TipoDeficiencia;
use App\Models\TipoDependencia;
use App\Models\Uf;
use App\Models\VinculoEmpregaticio;
use App\Services\CreateFuncionario;
use App\Validation\FuncionarioValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class FuncionarioController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $funcionarios = Auth::user()->funcionarios;
        $empresas = Auth::user()->empresas;
        return view('dashboard.funcionario.index', compact("funcionarios", "empresas"));
    }

    public function new($empresaId)
    {
        //precisa criar autorizacao
        $empresa = Auth::user()->empresas()->find($empresaId);
        $ufs = Uf::orderBy('nome')->get();
        $grausInstrucao = GrauInstrucao::orderBy('descricao')->get();
        $gruposSanguineos = GrupoSanguineo::orderBy('descricao')->get();
        $racas = Raca::orderBy('descricao')->get();
        $sexos = Sexo::orderBy('descricao')->get();
        $condicoesEstrangeiro = CondicaoEstrangeiro::orderBy('descricao')->get();
        $categoriasContrato = CategoriaContratoTrabalho::orderBy('descricao')->get();
        $vinculosEmpregaticios = VinculoEmpregaticio::orderBy('descricao')->get();
        $situacoesSeguroDesemprego = SituacaoSeguroDesemprego::orderBy('descricao')->get();
        $tiposDependencia = TipoDependencia::orderBy('descricao')->get();
        $estadosCivis = EstadoCivil::orderBy('descricao')->get();
        $deficiencias = TipoDeficiencia::orderBy('descricao')->get();
        $dow = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');

        return view('dashboard.funcionario.new.index', compact(
            'empresa',
            'sexos',
            'grausInstrucao',
            'estadosCivis',
            'ufs',
            'gruposSanguineos',
            'condicoesEstrangeiro',
            'categoriasContrato',
            'vinculosEmpregaticios',
            'situacoesSeguroDesemprego',
            'racas',
            'tiposDependencia',
            'dow',
            'deficiencias'
        ));
    }

    public function store(Request $request, $id)
    {

        $this->validate($request, FuncionarioValidation::getRules(), [], FuncionarioValidation::getNiceNames());
        dd($request->all());
        if (CreateFuncionario::handle($request->all(), $id)) {
            return redirect()->route('listFuncionarioToUser')->with('successAlert', 'Funcionário cadastrado com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function validateFuncionario(Request $request)
    {
        $this->validate($request, FuncionarioValidation::getRules(), [], FuncionarioValidation::getNiceNames());
    }

    public function validateDependente(Request $request)
    {

    }

}
