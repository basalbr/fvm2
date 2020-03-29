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
use App\Notifications\NewUsuario;
use App\Notifications\OrdemPagamentoCreated;
use App\Notifications\UsuarioRegistered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            /** @var Usuario $usuario */
            $usuario = Usuario::create($data);

            //Notifica os admins que um novo usuário foi criado
//            Usuario::notifyAdmins(new NewUsuario($usuario));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e->getMessage());
            return false;
        }

        return $usuario;
    }

}