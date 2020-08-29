<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\CategoriaContratoTrabalho;
use App\Models\CondicaoEstrangeiro;
use App\Models\Config;
use App\Models\Empresa;
use App\Models\EstadoCivil;
use App\Models\Funcionario;
use App\Models\GrauInstrucao;
use App\Models\GrupoSanguineo;
use App\Models\Raca;
use App\Models\Sexo;
use App\Models\SituacaoSeguroDesemprego;
use App\Models\TipoDeficiencia;
use App\Models\TipoDependencia;
use App\Models\Uf;
use App\Models\VinculoEmpregaticio;
use App\Services\ActivateFuncionario;
use App\Services\CreateChamado;
use App\Validation\ChamadoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FuncionarioController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        $funcionariosPendentes = Funcionario::query()->whereIn('funcionario.status', ['pendente']);
        if (!$request->has('tab') || $request->get('tab') == 'pendentes') {
            $funcionariosPendentes = $this->filterForm($funcionariosPendentes, $request);
        }
        $funcionariosPendentes = $funcionariosPendentes->select('funcionario.*')->get();

        $funcionarios = Funcionario::query()->whereNotIn('funcionario.status', ['pendente']);
        if (!$request->has('tab') || $request->get('tab') == 'ativos') {
            $funcionarios = $this->filterForm($funcionarios, $request);
        }
        $funcionarios = $funcionarios->select('funcionario.*')->get();
        return view('admin.funcionario.index', compact('funcionarios', 'funcionariosPendentes'));
    }

    public function activate($idEmpresa, $idFuncionario)
    {
        if (ActivateFuncionario::handle($idFuncionario)) {
            redirect()->route('showFuncionarioToAdmin', [$idEmpresa, $idFuncionario])->with('successAlert', 'Funcionário ativado com sucesso :)');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function store(Request $request)
    {
        $this->validate($request, ChamadoValidation::getRules(), [], ChamadoValidation::getNiceNames());
        if (CreateChamado::handle($request)) {
            return redirect()->route('listAtendimentosToUser')->with('successAlert', 'Seu chamado foi aberto com sucesso, você receberá uma notificação assim que respondermos :)');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function view($empresaId, $funcionarioId)
    {
        /** @var Empresa $empresa */
        $empresa = Empresa::findOrFail($empresaId);
        $funcionario = Funcionario::findOrFail($funcionarioId);
        $contrato = $funcionario->contratos()->latest()->first();
        return view('admin.funcionario.view.index', array_merge($this->getFormParameters(), compact('funcionario', 'empresa', 'contrato')));
    }

    public function getFormParameters()
    {
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
        $dow = Config::getDaysOfWeek();

        return compact(
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
        );
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function filterForm($query, $request)
    {
        $query->join('empresa', 'empresa.id', '=', 'funcionario.id_empresa')->join('usuario', 'usuario.id', '=', 'empresa.id_usuario');
        $query->where('empresa.status','!=', 'cancelado');
        if ($request->get('busca')) {
            $query->where(function ($q) use ($request) {
                $q->where('usuario.nome', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('usuario.telefone', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('usuario.email', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('empresa.nome_fantasia', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('empresa.razao_social', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('empresa.cnpj', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('funcionario.nome_completo', 'LIKE', '%' . $request->get('busca') . '%');
            });
        }
        if ($request->get('status')) {
            $query->where('funcionario.status', $request->get('status'));
        }
        if ($request->get('ordenar')) {
            switch ($request->get('ordenar')) {
                case 'nome_asc':
                    $query->orderBy('funcionario.nome_completo');
                    break;
                case 'nome_desc':
                    $query->orderBy('funcionario.nome_completo', 'desc');
                    break;
                case 'empresa_asc':
                    $query->orderBy('empresa.nome_fantasia');
                    break;
                case 'empresa_desc':
                    $query->orderBy('empresa.nome_fantasia', 'desc');
                    break;
                default:
                    $query->orderBy('empresa.nome_fantasia');
            }
        } else {
            $query->orderBy('empresa.nome_fantasia', 'asc');
        }
        return $query;
    }

}
