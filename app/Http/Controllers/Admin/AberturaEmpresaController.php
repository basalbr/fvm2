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
use App\Models\TipoTributacao;
use App\Models\Uf;
use App\Services\ChangeAberturaEmpresaStatus;
use App\Services\CreateAberturaEmpresa;
use App\Services\CreateEmpresaFromAberturaEmpresa;
use App\Services\SendMessageToAdmin;
use App\Validation\AberturaEmpresaSocioValidation;
use App\Validation\AberturaEmpresaValidation;
use App\Validation\EmpresaValidation;
use App\Validation\MensagemValidation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AberturaEmpresaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $empresasPendentes = AberturaEmpresa::whereNotIn('status', ['concluido', 'cancelado'])->orderBy('created_at', 'desc')->get();
        $empresasConcluidas = AberturaEmpresa::whereIn('status', ['cancelado', 'concluido'])->orderBy('created_at', 'desc')->get();
        return view('admin.abertura_empresa.index', compact("empresasPendentes", "empresasConcluidas"));
    }

    public function new()
    {
        $enquadramentos = EnquadramentoEmpresa::orderBy('descricao')->get();
        $naturezasJuridicas = NaturezaJuridica::orderBy('descricao')->get();
        $tiposTributacao = TipoTributacao::orderBy('descricao')->get();
        $ufs = Uf::orderBy('nome')->get();
        return view('dashboard.abertura_empresa.new.index', compact("enquadramentos", "naturezasJuridicas", "ufs", "tiposTributacao"));
    }

    public function view($id)
    {
        $aberturaEmpresa = AberturaEmpresa::find($id);
        return view('admin.abertura_empresa.view.index', compact("aberturaEmpresa"));
    }

    /**
     * Salva um novo processo de abertura de empresa no sistema
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        /*
         * Valida a requisição, retorna para página de origem caso falhe
         */
        $this->validate($request, AberturaEmpresaValidation::getRules(), [], AberturaEmpresaValidation::getNiceNames());

        /*
         * Caso o processo de abertura de empresa seja criado com sucesso redireciona para lista de processos de abertura de empresa
         */
        if (CreateAberturaEmpresa::handle($request->all())) {
            return redirect()->route('listAberturaEmpresaToUser')->with('successAlert', 'Sua solicitação de abertura de empresa foi cadastrada com sucesso.');
        }
        return redirect()->back()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * Cria uma empresa a partir de um processo de abertura de empresa
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createEmpresa($id)
    {
        $aberturaEmpresa = AberturaEmpresa::findOrFail($id);
        if (CreateEmpresaFromAberturaEmpresa::handle($aberturaEmpresa)) {
            return redirect()->route('showAberturaEmpresaToAdmin',$id)->with('successAlert', 'A empresa foi criada com sucesso!');
        }
        return redirect()->back()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * Altera os status do processo
     * @params int $id, string $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $status)
    {
        /* @var $aberturaEmpresa AberturaEmpresa*/
        $aberturaEmpresa = AberturaEmpresa::findOrFail($id);
        $aberturaEmpresa->update(['status'=>$status]);
        if (ChangeAberturaEmpresaStatus::handle($id, $status)) {
            return redirect()->route('showAberturaEmpresaToAdmin', $id)->with(['successAlert', 'O status foi alterado com sucesso']);
        }
        return redirect()->route('showAberturaEmpresaToAdmin', $id)->with(['alert', 'Ocorreu um erro inesperado']);
    }

    public function sendMessageToAdmin(Request $request, AberturaEmpresa $aberturaEmpresa)
    {
        $this->validate($request, MensagemValidation::getRules(), [], MensagemValidation::getNiceNames());
        $this->authorize('sendMessage', $aberturaEmpresa);
        if (SendMessageToAdmin::handle($request->all(), $aberturaEmpresa->getTable())) {
            return redirect()->route('viewAberturaEmpresa')->with('successAlert', 'A mensagem foi enviada, você receberá um e-mail quando respondermos.');
        }
        return redirect()->back()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * Valida uma request vinda de uma chamada json
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateAjax(Request $request)
    {
        $this->validate($request, AberturaEmpresaValidation::getRules(), [], AberturaEmpresaValidation::getNiceNames());
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
        $this->validate($request, AberturaEmpresaSocioValidation::getRules(), [], AberturaEmpresaSocioValidation::getNiceNames());
        return response()->json('success', 200);
    }

}
