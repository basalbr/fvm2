<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Reuniao;
use App\Models\Usuario;
use App\Notifications\NewReuniao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateReuniao
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            /* @var $reuniao Reuniao */
            $reuniao = Auth::user()->reunioes()->create($request->all());
            CreateOrdemPagamento::handle(Auth::user(), $reuniao->getTable(), $reuniao->id, 149.9);
            Usuario::notifyAdmins(new NewReuniao($reuniao));
            DB::commit();
        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}