<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\TipoRecalculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateTipoRecalculo
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {

            /* @var TipoRecalculo $alteracao */
            TipoRecalculo::create($request->all());
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}