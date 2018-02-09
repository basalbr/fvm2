<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\AberturaEmpresa;
use App\Models\Anexo;
use App\Models\Apuracao;
use App\Models\Chamado;
use App\Models\Empresa;
use App\Models\EnquadramentoEmpresa;
use App\Models\ImpostoRenda;
use App\Models\IrBensDireitos;
use App\Models\IrDependente;
use App\Models\IrDividaOnusReal;
use App\Models\IrDoacaoPolitica;
use App\Models\IrReciboDedutivel;
use App\Models\IrRendimentos;
use App\Models\IrRendimentosIsentos;
use App\Models\IrTipoOcupacao;
use App\Models\IrTributacaoExclusiva;
use App\Models\Mensagem;
use App\Models\NaturezaJuridica;
use App\Models\ProcessoDocumentoContabil;
use App\Models\RegimeCasamento;
use App\Models\TipoDependencia;
use App\Models\TipoTributacao;
use App\Models\Uf;
use App\Services\CreateEmpresa;
use App\Services\CreateEmpresaFromAberturaEmpresa;
use App\Services\CreateTempImpostoRenda;
use App\Services\SendMessageToAdmin;
use App\Services\SaveTempIR;
use App\Validation\EmpresaValidation;
use App\Validation\ImpostoRendaValidation;
use App\Validation\IrDependenteValidation;
use App\Validation\IrTempValidation;
use App\Validation\MensagemValidation;
use App\Validation\SocioValidation;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImpostoRendaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $irPendentes = Auth::user()->impostosRenda()
            ->whereNotIn('status', ['concluido', 'cancelado'])
            ->orderBy('exercicio', 'desc')
            ->get();

        $irConcluidos = Auth::user()->impostosRenda()
            ->whereIn('status', ['concluido', 'cancelado'])
            ->orderBy('exercicio', 'desc')
            ->get();

        $pessoas = Auth::user()->socios;

        return view('dashboard.imposto_renda.index', compact('irPendentes', 'irConcluidos', 'pessoas'));
    }

    public function saveTemp(Request $request, $id = 0)
    {
        if (SaveTempIR::handle($request, $id)) {
            return redirect()->route('listImpostoRendaToUser')->with('successAlert', Str::words(Auth::user()->nome, 1, ''). ', sua declaração foi salva em nosso sistema com sucesso.<br /><strong>Lembre-se</strong> que é necessário concluir o envio de documentos para que possamos fazer sua declaração.');
        }
        return 'deu merda';
    }

    public function new()
    {
        return view('dashboard.imposto_renda.new.index',$this->getParams());
    }

    public function view($id)
    {
        $ir = Auth::user()->impostosRenda()->findOrFail($id);
        return view('dashboard.imposto_renda.view.index', array_merge($this->getParams(), compact('ir')));
    }

    public function validateDependente(Request $request)
    {
        $this->validate($request, IrDependenteValidation::getRules(), [], IrDependenteValidation::getNiceNames());
        return response()->json('success', 200);
    }

    public function validateIr(Request $request)
    {
        $this->validate($request, ImpostoRendaValidation::getRules(), [], ImpostoRendaValidation::getNiceNames());
        return response()->json('success', 200);
    }

    public function validateIrTemp(Request $request)
    {
        $this->validate($request, IrTempValidation::getRules(), [], IrTempValidation::getNiceNames());
        return response()->json('success', 200);
    }

    public function getParams()
    {
        $anoAnterior = date('Y') - 1;
        $tiposOcupacao = IrTipoOcupacao::orderBy('descricao')->get();
        $irRendimentos = IrRendimentos::orderBy('descricao')->get(['descricao']);
        $irRendimentosIsentos = IrRendimentosIsentos::orderBy('descricao')->get(['descricao']);
        $irTributacoesExclusivas = IrTributacaoExclusiva::orderBy('descricao')->get(['descricao']);
        $irRecibosDedutiveis = IrReciboDedutivel::orderBy('descricao')->get(['descricao']);
        $irBensDireitos = IrBensDireitos::orderBy('descricao')->get(['descricao']);
        $irDividasOnus = IrDividaOnusReal::orderBy('descricao')->get(['descricao']);
        $irDoacoesPoliticas = IrDoacaoPolitica::orderBy('descricao')->get(['descricao']);
        $tiposDependente = TipoDependencia::orderBy('descricao')->get(['id', 'descricao']);
        return compact('anoAnterior',
            'tiposOcupacao',
            'irRendimentos',
            'irTributacoesExclusivas',
            'irRecibosDedutiveis',
            'irBensDireitos',
            'irDividasOnus',
            'irDoacoesPoliticas',
            'tiposDependente',
            'irRendimentosIsentos'
        );
    }

}
