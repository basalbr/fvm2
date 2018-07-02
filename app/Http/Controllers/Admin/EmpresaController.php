<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\AberturaEmpresa;
use App\Models\Empresa;
use App\Models\EnquadramentoEmpresa;
use App\Models\NaturezaJuridica;
use App\Models\RegimeCasamento;
use App\Models\TipoTributacao;
use App\Models\Uf;
use App\Services\ActivateEmpresa;
use App\Services\CreateEmpresa;
use App\Services\CreateEmpresaFromAberturaEmpresa;
use App\Services\SendMessageToAdmin;
use App\Validation\EmpresaValidation;
use App\Validation\MensagemValidation;
use App\Validation\SocioValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmpresaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ativar($idEmpresa)
    {

        $empresa = Empresa::find($idEmpresa);
        if ($empresa->status != 'Aprovado') {
            if (ActivateEmpresa::handle($empresa)) {
                return redirect()->route('listEmpresaToAdmin')->with('successAlert', 'Empresa ativada com sucesso.');
            }
        }
        return redirect()->back();
    }

    public function cnaes($id)
    {
        $empresa = Empresa::findOrFail($id);
        $ret = [];
        foreach ($empresa->cnaes as $cnae) {
            $ret[intval(preg_replace('/[^0-9]+/', '', $cnae->cnae->codigo), 10)] = $cnae->cnae->descricao;
        }
        dd($ret);
    }

    public function ativacaoProgramada(Request $request, $idEmpresa)
    {
        $empresa = Empresa::find($idEmpresa);
        $empresa->ativacao_programada = $request->get('ativacao_programada');
        $empresa->save();
        return redirect()->back()->with('successAlert', 'Ativação programada com sucesso para ' . $request->get('ativacao_programada'));
    }

    public function cancelarAtivacao($idEmpresa)
    {
        $empresa = Empresa::findOrFail($idEmpresa);
        $empresa->ativacao_programada = null;
        $empresa->save();
        return redirect()->back()->with('successAlert', 'Ativação cancelada com sucesso!');
    }

    public function index(Request $request)
    {
        $empresasAtivas = Empresa::query()->where('status', 'aprovado');
        if (!$request->has('tab') || $request->get('tab') == 'ativas') {
            $empresasAtivas = $this->filterForm($empresasAtivas, $request);
        }
        $empresasAtivas = $empresasAtivas->select('empresa.*')->get();

        $empresasPendentes = Empresa::query()->where('status', 'em_analise');
        if (!$request->has('tab') || $request->get('tab') == 'pendentes') {
            $empresasPendentes = $this->filterForm($empresasPendentes, $request);
        }
        $empresasPendentes = $empresasPendentes->select('empresa.*')->get();
        return view('admin.empresa.index', compact("empresasAtivas", "empresasPendentes"));
    }

    public function new()
    {
        $enquadramentos = EnquadramentoEmpresa::orderBy('descricao')->get();
        $naturezasJuridicas = NaturezaJuridica::orderBy('descricao')->get();
        $tiposTributacao = TipoTributacao::orderBy('descricao')->get();
        $regimesCasamento = RegimeCasamento::orderBy('descricao')->get();
        $ufs = Uf::orderBy('nome')->get();
        return view('admin.empresa.new.index', compact("enquadramentos", "naturezasJuridicas", "ufs", "tiposTributacao", "regimesCasamento"));
    }

    public function view($id)
    {
        $empresa = Empresa::find($id);
        $this->authorize('view', $empresa);
        return view('admin.empresa.view.index', compact("empresa"));
    }

    /**
     * Salva uma nova empresa no sistema
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        /*
         * Valida a requisição, retorna para página de origem caso falhe
         */
        $this->validate($request, EmpresaValidation::getRules(), [], EmpresaValidation::getNiceNames());

        /*
         * Caso o processo de migração de empresa seja criado com sucesso redireciona para lista de empresas
         */
        if (CreateEmpresa::handle($request->all())) {
            return redirect()->route('listEmpresaToUser')->with('successAlert', 'Sua solicitação de transferência de empresa foi enviada com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * Cria uma empresa a partir de um processo de abertura de empresa
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createEmpresa(Request $request)
    {
        $this->validate($request, EmpresaValidation::getRules(), [], EmpresaValidation::getNiceNames());
        if (CreateEmpresaFromAberturaEmpresa::handle($request->all())) {
            return redirect()->route('listEmpresaToAdmin')->with('successAlert', 'A empresa foi criada com sucesso e o processo de abertura de empresa foi encerrado.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function sendMessageToAdmin(Request $request, AberturaEmpresa $aberturaEmpresa)
    {
        $this->validate($request, MensagemValidation::getRules(), [], MensagemValidation::getNiceNames());
        $this->authorize('sendMessage', $aberturaEmpresa);
        if (SendMessageToAdmin::handle($request->all(), $aberturaEmpresa->getTable())) {
            return redirect()->route('viewAberturaEmpresa')->with('successAlert', 'A mensagem foi enviada, você receberá um e-mail quando respondermos.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * Valida uma request vinda de uma chamada json
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateAjax(Request $request)
    {
        $this->validate($request, EmpresaValidation::getRules(), [], EmpresaValidation::getNiceNames());
        return response()->json('success', 200);
    }

    /**
     * Valida uma request vinda de uma chamada json
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateSocio(Request $request)
    {
        $this->validate($request, SocioValidation::getRules(), [], SocioValidation::getNiceNames());
        return response()->json('success', 200);
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function filterForm($query, $request)
    {
        $query->join('usuario', 'empresa.id_usuario', '=', 'usuario.id');
        if ($request->get('busca')) {
            $query->where('empresa.nome_fantasia', 'LIKE', '%' . $request->get('busca') . '%')
                ->orWhere('empresa.razao_social', 'LIKE', '%' . $request->get('busca') . '%')
                ->orWhere('empresa.cnpj', 'LIKE', '%' . $request->get('busca') . '%')
                ->orWhere('usuario.nome', 'LIKE', '%' . $request->get('busca') . '%')
                ->orWhere('usuario.email', 'LIKE', '%' . $request->get('busca') . '%');
        }
        if ($request->get('ordenar')) {
            switch ($request->get('ordenar')) {
                case 'empresa_asc':
                    $query->orderBy('empresa.nome_fantasia');
                    break;
                case 'empresa_desc':
                    $query->orderBy('empresa.nome_fantasia', 'desc');
                    break;
                case 'usuario_asc':
                    $query->orderBy('usuario.nome');
                    break;
                case 'usuario_desc':
                    $query->orderBy('usuario.nome', 'desc');
                    break;
                default:
                    $query->orderBy('empresa.nome_fantasia');
            }
        }
        return $query;
    }

}
