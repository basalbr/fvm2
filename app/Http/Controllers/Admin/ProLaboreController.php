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
use App\Models\Prolabore;
use App\Models\RegimeCasamento;
use App\Models\Socio;
use App\Models\TipoTributacao;
use App\Models\Uf;
use App\Services\CreateEmpresa;
use App\Services\CreateEmpresaFromAberturaEmpresa;
use App\Services\SendInformacaoApuracao;
use App\Services\SendMessageToAdmin;
use App\Services\UpdateApuracao;
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

class ProLaboreController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create($idSocio){
        $socio = Socio::findOrFail($idSocio);
        $competencia =date('Y-m-d', strtotime(date('Y-m') . " -1 month"));
        return view('admin.pro_labore.new.index', compact('socio', 'competencia'));
    }

    public function index()
    {
        $sociosPendentes = Socio::join('empresa', 'empresa.id', '=', 'socio.id_empresa')
            ->whereDoesntHave('pro_labores', function($q){
                $q->whereMonth('pro_labore.created_at', '=', date('m'));
            })
            ->where('socio.pro_labore', '>', 0)
            ->where('empresa.deleted_at', '=', null)
            ->orderBy('empresa.nome_fantasia', 'asc')
            ->groupBy('socio.id', 'socio.id_empresa', 'socio.nome','socio.principal', 'socio.pro_labore')
            ->select('socio.id', 'socio.pro_labore', 'socio.nome', 'socio.id_empresa')->get();
        $historicoProlabore = Prolabore::orderBy('created_at', 'desc')->get();
        return view('admin.pro_labore.index', compact('sociosPendentes', 'historicoProlabore'));
    }

    public function validateGuia(Request $request)
    {
        $rules = ['arquivo' => 'max:10240|required|file|mimes:pdf'];
        $niceNames = ['arquivo' => 'Guia'];
        $this->validate($request, $rules, [], $niceNames);
    }

    public function update(Request $request, $idApuracao)
    {
        if (UpdateApuracao::handle($request, $idApuracao)) {
            return redirect()->route('showApuracaoToAdmin', [$idApuracao])->with('successAlert', 'Apuração atualizada com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }


}
