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
use Illuminate\Support\Facades\DB;

class RegisterUsuario
{
    /**
     * @param mixed $data
     * @return bool
     */
    public static function handle($data)
    {
        DB::beginTransaction();
        try {
            $usuario = new Usuario($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        $usuario->notify(new OrdemPagamentoCreated($ordemPagamento));
        return true;
    }

}