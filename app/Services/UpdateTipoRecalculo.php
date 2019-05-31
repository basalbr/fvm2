<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\AlteracaoCampo;
use App\Models\TipoRecalculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateTipoRecalculo
{

    public static function handle(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            /* @var TipoRecalculo $alteracao */
            $alteracao = TipoRecalculo::findOrFail($id);
            $alteracao->update($request->all());
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}