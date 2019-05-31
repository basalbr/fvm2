<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Usuario;
use App\Notifications\NewRecalculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateRecalculo
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            $recalculo = Auth::user()->recalculos()->create($request->all());
            CreateOrdemPagamento::handle(Auth::user(), $recalculo->getTable(), $recalculo->id, $recalculo->tipo->valor);
            Usuario::notifyAdmins(new NewRecalculo($recalculo));
            DB::commit();
        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}