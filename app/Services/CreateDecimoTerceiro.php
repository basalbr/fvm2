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
use App\Models\DecimoTerceiro;
use App\Models\Mensagem;
use App\Models\Usuario;
use App\Notifications\NewChamado;
use App\Notifications\NewDecimoTerceiro;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CreateDecimoTerceiro
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            /** @var Chamado $chamado */
            $decimoTerceiro = DecimoTerceiro::create(['id_empresa' => $request->get('id_empresa'), 'descricao' => $request->get('descricao')]);
            if (count($request->get('anexos'))) {
                foreach ($request->get('anexos') as $arquivo) {
                    Anexo::create([
                        'id_referencia' => $decimoTerceiro->id,
                        'referencia' => $decimoTerceiro->getTable(),
                        'arquivo' => $arquivo['arquivo'],
                        'descricao' => $arquivo['descricao']
                    ]);
                    Storage::move('temp/' . $arquivo['arquivo'], 'public/anexos/' . $decimoTerceiro->getTable() . '/' . $decimoTerceiro->id . '/' . $arquivo['arquivo']);
                }
            }
            $decimoTerceiro->empresa->usuario->notify(new NewDecimoTerceiro($decimoTerceiro));
            //Notifica o usuário que existe um décimo terceiro para a empresa dele
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}