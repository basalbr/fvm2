<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\AberturaEmpresa;
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

class DashboardController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $pagamentosPendentes = Auth::user()->ordensPagamento()->where('status', '!=', 'Paga')->where('status', '!=', 'Disponível')->count();
        $apuracoesPendentes = Apuracao::join('empresa', 'apuracao.id_empresa', '=', 'empresa.id')
            ->where('empresa.id_usuario', '=', Auth::user()->id)
            ->whereNotIn('apuracao.status', ['concluido', 'sem_movimento'])
            ->count();
        $processosPendentes = ProcessoDocumentoContabil::join('empresa','empresa.id','=','processo_documento_contabil.id_empresa')
        ->where('empresa.id_usuario','=',Auth::user()->id)
        ->where('processo_documento_contabil.status','!=','concluido')
        ->where('processo_documento_contabil.status','!=','sem_movimento')->count();
        return view('dashboard.index', compact("pagamentosPendentes", 'apuracoesPendentes', 'processosPendentes'));
    }

}
