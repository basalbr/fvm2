<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Mensagem;
use App\Models\ProcessoDocumentoContabil;
use App\Models\TipoDocumentoContabil;
use App\Services\ContabilizarDocumentoContabil;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use ZipArchive;

class DocumentoContabilController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $processosPendentes = ProcessoDocumentoContabil::query();
        $processosPendentes->whereNotIn('processo_documento_contabil.status', ['concluido'])->orderBy('status', 'desc')->orderBy('created_at', 'desc');
        $processosPendentes = $processosPendentes->select('processo_documento_contabil.*')->paginate(10);

        $processosConcluidos = ProcessoDocumentoContabil::query();
        $processosConcluidos->whereIn('processo_documento_contabil.status', ['concluido']);
        $processosConcluidos = $processosConcluidos->select('processo_documento_contabil.*')->paginate(10);

        return view('admin.documentos_contabeis.index', compact('processosPendentes', 'processosConcluidos'));
    }

    public function view($idProcesso)
    {
        $processo = ProcessoDocumentoContabil::findOrFail($idProcesso);
        $tiposDocumentos = TipoDocumentoContabil::orderBy('descricao', 'desc')->get();
        $qtdeDocumentos = Mensagem::join('anexo', 'anexo.id_referencia', 'mensagem.id')
            ->where('anexo.referencia', 'mensagem')
            ->where('mensagem.referencia', 'processo_documento_contabil')
            ->where('mensagem.id_referencia', $idProcesso)
            ->count();
        $qtdeDocumentos += $processo->anexos->count();
        return view('admin.documentos_contabeis.view.index', compact('processo', 'tiposDocumentos', 'qtdeDocumentos'));
    }

    public function contabilizar($idProcesso)
    {
        $processo = ProcessoDocumentoContabil::findOrFail($idProcesso);
        if (ContabilizarDocumentoContabil::handle($processo)) {
            return redirect()->route('listDocumentosContabeisToAdmin')->with('successAlert', 'Processo contabilizado com sucesso!');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function downloadZip($processoId)
    {
        $cont = 0;
        $apuracao = ProcessoDocumentoContabil::findOrFail($processoId);
        $files = array();
        # create new zip object
        $zip = new ZipArchive();
        # create a temp file & open it
        $tmp_file = @tempnam('.', '');
        $zip->open($tmp_file, ZipArchive::CREATE);

        foreach ($apuracao->anexos as $anexo) {
            $download_file = file_get_contents(asset(public_path() . 'storage/anexos/' . $anexo->referencia . '/' . $anexo->id_referencia . '/' . $anexo->arquivo));
            $zip->addFromString($cont . str_replace('/', ' ', $anexo->descricao) . '.' . pathinfo($anexo->arquivo, PATHINFO_EXTENSION), $download_file);
            $cont++;
        }
        foreach ($apuracao->mensagens as $message) {
            if ($message->anexo) {
                $download_file = file_get_contents(asset(public_path() . 'storage/anexos/' . $message->anexo->referencia . '/' . $message->anexo->id_referencia . '/' . $message->anexo->arquivo));
                $zip->addFromString($cont . str_replace('/', ' ',$message->anexo->descricao), $download_file);
                $cont++;
            }
        }
        $zip->close();
        # send the file to the browser as a download
        header('Content-disposition: attachment; filename="documentos.zip"');
        header('Content-type: application/zip');
        readfile($tmp_file);
        unlink($tmp_file);
    }


}
