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
use App\Notifications\DocumentosContabeisSemMovimento;
use App\Notifications\DocumentosContabeisSent;
use App\Notifications\NewChamado;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FlagDocumentosContabeisAsSemMovimento
{

    public static function handle($idProcesso)
    {
        DB::beginTransaction();
        try {
            /** @var ProcessoDocumentoContabil $processo */
            $processo = ProcessoDocumentoContabil::join('empresa', 'processo_documento_contabil.id_empresa', '=', 'empresa.id')
                ->where('empresa.id_usuario', '=', Auth::user()->id)
                ->where('processo_documento_contabil.id', '=', $idProcesso)
                ->select('processo_documento_contabil.*')
                ->first();

            $processo->status = 'sem_movimento';
            $processo->save();
            //Notifica admins que existe um novo funcionario cadastrado
            Usuario::notifyAdmins(new DocumentosContabeisSemMovimento($processo));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}