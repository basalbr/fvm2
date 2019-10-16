<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\ContratoTrabalho;
use App\Models\Reuniao;
use App\Models\RecalculoInformacaoExtra;
use App\Notifications\GuiaAvailableInRecalculo;
use App\Notifications\NewInfoInRecalculo;
use App\Notifications\NewStatusReuniao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateReuniao
{

    public static function handle(Request $request, int $idReuniao)
    {
        DB::beginTransaction();
        try {

            /* @var Reuniao $reuniao */
            $reuniao = Reuniao::findOrFail($idReuniao);
            $reuniao->update($request->all());
            $reuniao->usuario->notify(new NewStatusReuniao($reuniao));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}