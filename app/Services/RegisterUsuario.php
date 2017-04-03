<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\OrdemPagamento;
use App\Models\Usuario;
use App\Notifications\OrdemPagamentoCreated;
use App\Notifications\UsuarioRegistered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterUsuario
{
    /**
     * @param $data
     * @return Usuario|bool
     */
    public static function handle($data)
    {
        DB::beginTransaction();
        try {
            $usuario = Usuario::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        return $usuario;
    }

}