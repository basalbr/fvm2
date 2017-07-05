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
use App\Models\Usuario;
use App\Notifications\GuiaAvailableInApuracao;
use App\Notifications\NewChamado;
use App\Notifications\NewInfoInApuracao;
use App\Notifications\NewStatusApuracao;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateApuracao
{

    public static function handle(Request $request, int $idApuracao)
    {
        DB::beginTransaction();
        try {

            /* @var Apuracao $apuracao */
            $apuracao = Apuracao::findOrFail($idApuracao);
            $apuracao->update($request->all());

            if ($request->get('guia')) {
                Storage::move('temp/' . $request->get('guia'), 'public/anexos/' . $apuracao->getTable() . '/' . $apuracao->id . '/' . $request->get('guia'));
                $apuracao->empresa->usuario->notify(new GuiaAvailableInApuracao($apuracao));
            }
            $apuracao->empresa->usuario->notify(new NewStatusApuracao($apuracao));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}