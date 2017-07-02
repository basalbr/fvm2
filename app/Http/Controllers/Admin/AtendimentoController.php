<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\AberturaEmpresa;
use App\Models\Alteracao;
use App\Models\Apuracao;
use App\Models\Chamado;
use App\Models\Empresa;
use App\Models\EnquadramentoEmpresa;
use App\Models\Mensagem;
use App\Models\NaturezaJuridica;
use App\Models\ProcessoDocumentoContabil;
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
use Illuminate\Support\Facades\DB;

class AtendimentoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $chamados = Chamado::orderBy('created_at', 'desc')->get();
        //Buscar somente empresas que possuem mensagens não lidas
        $empresas = Empresa::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('mensagem')
                ->whereRaw('mensagem.id_referencia = empresa.id')
                ->where('mensagem.referencia', '=', 'empresa')
                ->where('mensagem.lida', '=', 0)
                ->where('deleted_at', '=', null)->limit(1);
        })->get();
        $aberturaEmpresas = AberturaEmpresa::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('mensagem')
                ->whereRaw('mensagem.id_referencia = abertura_empresa.id')
                ->where('mensagem.referencia', '=', 'abertura_empresa')
                ->where('mensagem.lida', '=', 0)
                ->where('deleted_at', '=', null)->limit(1);
        })->get();

        $solicitacoes = Alteracao::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('mensagem')
                ->whereRaw('mensagem.id_referencia = alteracao.id')
                ->where('mensagem.referencia', '=', 'alteracao')
                ->where('mensagem.lida', '=', 0)
                ->where('deleted_at', '=', null)->limit(1);
        })->orderBy('created_at', 'desc')->get();

        $apuracoes = Apuracao::whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('mensagem')
                    ->whereRaw('mensagem.id_referencia = apuracao.id')
                    ->where('mensagem.referencia', '=', 'apuracao')
                    ->where('mensagem.lida', '=', 0)
                    ->where('deleted_at', '=', null)->limit(1);
            })->orderBy('created_at', 'desc')->select('apuracao.*')->get();

        $documentosContabeis = ProcessoDocumentoContabil::whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('mensagem')
                    ->whereRaw('mensagem.id_referencia = processo_documento_contabil.id')
                    ->where('mensagem.referencia', '=', 'processo_documento_contabil')
                    ->where('mensagem.lida', '=', 0)
                    ->where('deleted_at', '=', null)->limit(1);
            })->orderBy('created_at', 'desc')->select('processo_documento_contabil.*')->get();

        return view('admin.atendimento.index', compact("empresas", 'chamados', 'solicitacoes', 'aberturaEmpresas', 'apuracoes', 'documentosContabeis'));
    }

}
