<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

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

    public function index(Request $request)
    {
        $chamados = Auth::user()->chamados();
        //Buscar somente empresas que possuem mensagens não lidas
        $chamados = $this->filterForm($chamados, $request);

        $chamados = $chamados->select('chamado.*')->get();
        return view('dashboard.atendimento.index', compact('chamados'));
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function filterForm($query, $request)
    {
        if ($request->get('busca')) {
            $query->where('mensagem.mensagem', 'LIKE', '%' . $request->get('busca') . '%');
        }
        if ($request->get('ordenar')) {
            switch ($request->get('ordenar')) {
                case 'created_asc':
                    $query->orderBy('chamado.created_at');
                    break;
                case 'created_desc':
                    $query->orderBy('chamado.created_at', 'desc');
                    break;
                default:
                    $query->orderBy('chamado.created_at', 'desc');
            }
        }else{
            $query->orderBy('chamado.created_at', 'desc');
        }
        return $query;
    }

}
