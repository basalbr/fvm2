<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Empresa;
use App\Models\ProcessoDocumentoContabil;
use App\Models\TipoDocumentoContabil;
use App\Services\ContabilizarDocumentoContabil;
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

    public function index()
    {
        $processosPendentes = ProcessoDocumentoContabil::query();
        $processosPendentes->whereNotIn('processo_documento_contabil.status', ['concluido', 'sem_movimento']);
        $processosPendentes = $processosPendentes->select('processo_documento_contabil.*')->paginate(10);

        $processosConcluidos = ProcessoDocumentoContabil::query();
        $processosConcluidos->whereIn('processo_documento_contabil.status', ['concluido', 'sem_movimento']);
        $processosConcluidos = $processosConcluidos->select('processo_documento_contabil.*')->paginate(10);

        return view('admin.documentos_contabeis.index', compact('processosPendentes', 'processosConcluidos'));
    }

    public function view($idProcesso)
    {
        $processo = ProcessoDocumentoContabil::findOrFail($idProcesso);
        $tiposDocumentos = TipoDocumentoContabil::orderBy('descricao', 'desc')->get();
        return view('admin.documentos_contabeis.view.index', compact('processo', 'tiposDocumentos'));
    }

    public function contabilizar($idProcesso)
    {
        $processo = ProcessoDocumentoContabil::findOrFail($idProcesso);
        if (ContabilizarDocumentoContabil::handle($processo)) {
            return redirect()->route('listDocumentosContabeisToAdmin')->with('successAlert', 'Processo contabilizado com sucesso!');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }


}
