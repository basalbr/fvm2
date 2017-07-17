<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\Empresa;
use App\Models\ProcessoDocumentoContabil;
use App\Models\TipoDocumentoContabil;
use App\Services\FlagDocumentosContabeisAsSemMovimento;
use App\Services\SendDocumentosContabeis;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DocumentoContabilController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function abrirProcessos()
    {
        $empresas = Empresa::where('status', '=', 'aprovado')->get();
        foreach ($empresas as $empresa) {
            /* @var Empresa $empresa */
            $empresa->abrirProcessosDocumentosContabeis();
        }
    }

  public function index(){
      $processosPendentes = ProcessoDocumentoContabil::query();
      $processosPendentes->join('empresa','empresa.id','=','processo_documento_contabil.id_empresa');
      $processosPendentes->where('empresa.id_usuario','=',Auth::user()->id);
      $processosPendentes->where('processo_documento_contabil.status','!=','concluido');
      $processosPendentes->where('processo_documento_contabil.status','!=','sem_movimento');
      $processosPendentes = $processosPendentes->select('processo_documento_contabil.*')->get();

      $processosConcluidos = ProcessoDocumentoContabil::query();
      $processosConcluidos->join('empresa','empresa.id','=','processo_documento_contabil.id_empresa');
      $processosConcluidos->where('empresa.id_usuario','=',Auth::user()->id);
      $processosConcluidos->whereIn('processo_documento_contabil.status',['concluido', 'sem_movimento']);
      $processosConcluidos = $processosConcluidos->select('processo_documento_contabil.*')->get();

      return view('dashboard.documentos_contabeis.index', compact('processosPendentes' , 'processosConcluidos'));
  }

  public function view($idProcesso){
      $processo = ProcessoDocumentoContabil::join('empresa', 'processo_documento_contabil.id_empresa', '=', 'empresa.id')
          ->where('empresa.id_usuario', '=', Auth::user()->id)
          ->where('processo_documento_contabil.id', '=', $idProcesso)
          ->select('processo_documento_contabil.*')
          ->first();
      $tiposDocumentos = TipoDocumentoContabil::orderBy('descricao', 'desc')->get();
      return view('dashboard.documentos_contabeis.view.index', compact('processo', 'tiposDocumentos'));
  }

  public function update(Request $request, $idProcesso){
      $rules = ['anexos'=>'required|array'];
      $niceNames = ['Documentos'];
      $this->validate($request, $rules, [], $niceNames);
      if (SendDocumentosContabeis::handle($request, $idProcesso)) {
          return redirect()->route('listDocumentosContabeisToUser')->with('successAlert', 'Seus documentos foram enviados com sucesso, em breve iremos contabilizá-los ;)');
      }
      return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
  }

    public function semMovimento($idProcesso){
        if (FlagDocumentosContabeisAsSemMovimento::handle($idProcesso)) {
            return redirect()->route('listDocumentosContabeisToUser')->with('successAlert', 'Nós recebemos sua notificação de que não houve movimentação');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

}
