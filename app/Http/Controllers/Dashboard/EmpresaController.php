<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\AberturaEmpresa;
use App\Models\Empresa;
use App\Models\EnquadramentoEmpresa;
use App\Models\NaturezaJuridica;
use App\Models\RegimeCasamento;
use App\Models\TipoTributacao;
use App\Models\Uf;
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
use Illuminate\Support\Facades\Auth;

class EmpresaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $empresas = Empresa::where('id_usuario', '=', Auth::user()->id)->get();
        return view('dashboard.empresa.index', compact("empresas"));
    }

    public function new()
    {
        $enquadramentos = EnquadramentoEmpresa::orderBy('descricao')->get();
        $naturezasJuridicas = NaturezaJuridica::orderBy('descricao')->get();
        $tiposTributacao = TipoTributacao::orderBy('descricao')->get();
        $regimesCasamento = RegimeCasamento::orderBy('descricao')->get();
        $ufs = Uf::orderBy('nome')->get();
        return view('dashboard.empresa.new.index', compact("enquadramentos", "naturezasJuridicas", "ufs", "tiposTributacao", "regimesCasamento"));
    }

    public function view($id)
    {
        /* @var $empresa Empresa*/
        $empresa = Auth::user()->empresas()->findOrFail($id);
        $qtdeDocumentos = $empresa->anexos()->count();
        $qtdeDocumentos += $empresa->mensagens()->whereHas('anexo')->count();
        $contrato_razao_social = $empresa->razao_social;
        $contrato_cnpj = $empresa->cnpj;
        $contrato_mensalidade = $empresa->getMensalidadeAtual()->getValor();
        $contrato_docs_fiscais = $empresa->getMensalidadeAtual()->qtde_documento_fiscal;
        $contrato_funcionarios = $empresa->getMensalidadeAtual()->qtde_funcionario;
        return view('dashboard.empresa.view.index', compact("empresa", 'qtdeDocumentos', 'contrato_cnpj', 'contrato_razao_social', 'contrato_docs_fiscais', 'contrato_funcionarios', 'contrato_mensalidade'));
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

}
