<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Anexo;
use App\Models\Apuracao;
use App\Models\ApuracaoInformacaoExtra;
use App\Models\Chamado;
use App\Models\ContratoTrabalho;
use App\Models\ImpostoInformacaoExtra;
use App\Models\Mensagem;
use App\Models\ProcessoFolha;
use App\Models\Prolabore;
use App\Models\Usuario;
use App\Notifications\NewChamado;
use App\Notifications\NewInfoInApuracao;
use App\Notifications\ProcessoFolhaSent;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendProcessoFolha
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {

            /** @var $processoFolha ProcessoFolha */
            $processoFolha = ProcessoFolha::create($request->all());

            if ($request->has('irrf')) {
                Storage::move('temp/' . $request->get('irrf'), 'public/anexos/' . $processoFolha->getTable() . '/' . $processoFolha->id . '/' . $request->get('irrf'));
            }

            if ($request->has('inss')) {
                Storage::move('temp/' . $request->get('inss'), 'public/anexos/' . $processoFolha->getTable() . '/' . $processoFolha->id . '/' . $request->get('inss'));
            }

            if ($request->has('recibo_folha')) {
                Storage::move('temp/' . $request->get('recibo_folha'), 'public/anexos/' . $processoFolha->getTable() . '/' . $processoFolha->id . '/' . $request->get('recibo_folha'));
            }

            if ($request->has('fgts')) {
                Storage::move('temp/' . $request->get('fgts'), 'public/anexos/' . $processoFolha->getTable() . '/' . $processoFolha->id . '/' . $request->get('fgts'));
            }

            $processoFolha->empresa->usuario->notify(new ProcessoFolhaSent($processoFolha));
            DB::commit();
        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}