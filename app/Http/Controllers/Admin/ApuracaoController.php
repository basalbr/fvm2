<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\AberturaEmpresa;
use App\Models\Apuracao;
use App\Models\Chamado;
use App\Models\Empresa;
use App\Models\EnquadramentoEmpresa;
use App\Models\Imposto;
use App\Models\Mensagem;
use App\Models\NaturezaJuridica;
use App\Models\RegimeCasamento;
use App\Models\TipoTributacao;
use App\Models\Uf;
use App\Services\CreateEmpresa;
use App\Services\CreateEmpresaFromAberturaEmpresa;
use App\Services\SendInformacaoApuracao;
use App\Services\SendMessageToAdmin;
use App\Services\UploadAnexo;
use App\Validation\AnexoValidation;
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
use Psr\Http\Message\RequestInterface;

class ApuracaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function index()
    {
        $apuracoesPendentes = Apuracao::where('apuracao.status', '!=', 'concluido')
            ->orderBy('apuracao.competencia', 'desc')
            ->select('apuracao.*')
            ->get();
        $apuracoesConcluidas = Apuracao::where('apuracao.status', '=', 'concluido')
            ->orderBy('apuracao.competencia', 'desc')
            ->select('apuracao.*')
            ->get();
        return view('admin.apuracao.index', compact('apuracoesConcluidas', 'apuracoesPendentes'));
    }


}
