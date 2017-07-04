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
use App\Models\Imposto;
use App\Models\Mensagem;
use App\Models\NaturezaJuridica;
use App\Models\RegimeCasamento;
use App\Models\TipoTributacao;
use App\Models\Uf;
use App\Models\Usuario;
use App\Notifications\NewInfoInApuracao;
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

    public function abrirApuracoes()
    {
        $empresas = Empresa::where('status', '=', 'aprovado')->get();
        foreach ($empresas as $empresa) {
            /* @var Empresa $empresa */
            $empresa->abrirApuracoes();
        }
    }

    public function index()
    {
        $apuracoesPendentes = Apuracao::join('empresa', 'apuracao.id_empresa', '=', 'empresa.id')
            ->where('empresa.id_usuario', '=', Auth::user()->id)
            ->where('apuracao.status', '!=', 'concluido')
            ->orderBy('apuracao.competencia', 'desc')
            ->select('apuracao.*')
            ->get();
        $apuracoesConcluidas = Apuracao::join('empresa', 'apuracao.id_empresa', '=', 'empresa.id')
            ->where('empresa.id_usuario', '=', Auth::user()->id)
            ->where('apuracao.status', '=', 'concluido')
            ->orderBy('apuracao.competencia', 'desc')
            ->select('apuracao.*')
            ->get();
        return view('dashboard.apuracao.index', compact('apuracoesConcluidas', 'apuracoesPendentes'));
    }

    public function calendario()
    {
        return view('dashboard.calendario_impostos.index');
    }


    public function update(Request $request, $idApuracao)
    {
        if (SendInformacaoApuracao::handle($request, $idApuracao)) {
            return redirect()->route('showApuracaoToUser', [$idApuracao])->with('successAlert', 'Nós recebemos suas informações e em breve realizaremos a apuração. Obrigado :)');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function semMovimento($idApuracao){
        $apuracao = Apuracao::join('empresa', 'apuracao.id_empresa', '=', 'empresa.id')
            ->where('empresa.id_usuario', '=', Auth::user()->id)
            ->where('apuracao.id', '=', $idApuracao)
            ->select('apuracao.*')
            ->first();
        $apuracao->status = 'sem_movimento';
        $apuracao->save();
        Usuario::notifyAdmins(new NewInfoInApuracao($apuracao));
        return redirect()->route('listApuracoesToUser')->with('successAlert', 'Nós recebemos suas informações e em breve realizaremos a apuração. Obrigado :)');
    }

    public function view($idApuracao)
    {
        $apuracao = Apuracao::join('empresa', 'apuracao.id_empresa', '=', 'empresa.id')
            ->where('empresa.id_usuario', '=', Auth::user()->id)
            ->where('apuracao.id', '=', $idApuracao)
            ->select('apuracao.*')
            ->first();
        return view('dashboard.apuracao.view.index', compact('apuracao'));
    }


    public function validateAnexo(Request $request)
    {
        $rules = ['arquivo' => 'required|file|max:10240|mimes:zip'];
        $niceNames = ['arquivo' => 'Arquivo'];
        $this->validate($request, $rules, [], $niceNames);
    }

}
