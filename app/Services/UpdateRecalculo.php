<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\ContratoTrabalho;
use App\Models\Recalculo;
use App\Models\RecalculoInformacaoExtra;
use App\Notifications\GuiaAvailableInRecalculo;
use App\Notifications\NewInfoInRecalculo;
use App\Notifications\NewStatusRecalculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateRecalculo
{

    public static function handle(Request $request, int $idRecalculo)
    {
        DB::beginTransaction();
        try {

            /* @var Recalculo $recalculo */
            $recalculo = Recalculo::findOrFail($idRecalculo);
            $recalculo->update($request->all());

            if ($request->get('guia')) {
                Storage::move('temp/' . $request->get('guia'), 'public/' . $recalculo->getTable() . '/' . $recalculo->id . '/' . $request->get('guia'));
                $recalculo->usuario->notify(new GuiaAvailableInRecalculo($recalculo));
            }
            $recalculo->usuario->notify(new NewStatusRecalculo($recalculo));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}