<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Anexo;
use App\Models\Chamado;
use App\Models\ContratoTrabalho;
use App\Models\DocumentoContabil;
use App\Models\Mensagem;
use App\Models\ProcessoDocumentoContabil;
use App\Models\Usuario;
use App\Notifications\DocumentosContabeisSent;
use App\Notifications\NewChamado;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendDocumentosContabeis
{

    public static function handle($idProcesso)
    {
        DB::beginTransaction();
        try {
            /* @var $processo ProcessoDocumentoContabil */
            $processo = Auth::user()->documentosContabeis()->findOrFail($idProcesso);
            $processo->status = 'documentos_enviados';
            $processo->save();
//            Usuario::notifyAdmins(new DocumentosContabeisSent($processo));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}