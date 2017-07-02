<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\AberturaEmpresa;
use App\Models\Chamado;
use App\Models\Empresa;
use App\Models\EnquadramentoEmpresa;
use App\Models\Mensagem;
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
use Illuminate\Support\Facades\DB;

class PagamentoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function updateMensalidades(){

    }

    public function index()
    {
        $pagamentosPendentes = Auth::user()->ordensPagamento()->where('status', '!=', 'Paga')->where('status', '!=', 'Disponível')->orderBy('created_at')->get();
        $historicoPagamento = Auth::user()->ordensPagamento()->whereIn('status', ['Paga', 'Disponível'])->orderBy('created_at')->get();
        return view('dashboard.pagamentos.index', compact("pagamentosPendentes", 'historicoPagamento'));
    }

}
