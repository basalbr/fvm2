<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Usuario;
use App\Notifications\KilledByInadimplency;
use App\Notifications\UsuarioDisabled;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DisableUsuario
{

    /**
     * @param Usuario $usuario
     * @return bool
     */
    public static function handle(Usuario $usuario)
    {
        DB::beginTransaction();
        try {
            //Notifica admins que existe um novo funcionario cadastrado
            $usuario->notify(new UsuarioDisabled());
            $usuario->delete();
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}