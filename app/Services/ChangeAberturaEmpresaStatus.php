<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\AberturaEmpresa;
use App\Models\Cnae;
use App\Models\Config;
use App\Models\Usuario;
use App\Notifications\NewAberturaEmpresa;
use App\Notifications\NewAberturaEmpresaStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeAberturaEmpresaStatus
{

    public static function handle($id, $status)
    {
        DB::beginTransaction();
        try {
            /** @var AberturaEmpresa $aberturaEmpresa */
            $aberturaEmpresa = AberturaEmpresa::findOrFail($id);
            $aberturaEmpresa->update(['status'=>$status]);
            $aberturaEmpresa->usuario->notify(new NewAberturaEmpresaStatus($aberturaEmpresa));
            DB::commit();
        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}