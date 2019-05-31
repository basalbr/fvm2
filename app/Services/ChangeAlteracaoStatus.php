<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Alteracao;
use App\Notifications\NewAlteracaoStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeAlteracaoStatus
{

    public static function handle($id, $status)
    {
        DB::beginTransaction();
        try {
            /** @var Alteracao $alteracao */
            $alteracao = Alteracao::findOrFail($id);
            $alteracao->update(['status'=>$status]);
            $alteracao->usuario->notify(new NewAlteracaoStatus($alteracao));
            DB::commit();
        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}