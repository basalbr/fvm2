<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Tributacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RemoveTributacaoFromEmpresa
{

    public static function handle($idTributacao)
    {
        DB::beginTransaction();
        try {
            /** @var Tributacao $tributacao * */
            $tributacao = Tributacao::findOrFail($idTributacao);
            $tributacao->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            return false;
        }
    }
}