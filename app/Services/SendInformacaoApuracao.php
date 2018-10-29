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
use App\Notifications\NewChamado;
use App\Notifications\NewInfoInApuracao;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendInformacaoApuracao
{

    public static function handle(Request $request, int $idApuracao)
    {
        DB::beginTransaction();
        try {

            /* @var Apuracao $apuracao */
            $apuracao = Apuracao::findOrFail($idApuracao);
            if (count($request->get('informacoes_extras'))) {
                foreach ($request->get('informacoes_extras') as $idInfoExtra => $info) {
                    $apuracao->informacoes()->create(['id_informacao_extra' => $idInfoExtra, 'informacao' => $info]);
                    $tipoApuracao = ImpostoInformacaoExtra::find($idInfoExtra);
                    if ($tipoApuracao->tipo == 'anexo') {
                        Storage::move('temp/' . $info, 'public/anexos/' . $apuracao->getTable() . '/' . $apuracao->id . '/' . $info);
                    }
                }
            }
//            Usuario::notifyAdmins(new NewInfoInApuracao($apuracao));
            $apuracao->status = 'informacoes_enviadas';
            $apuracao->save();
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}