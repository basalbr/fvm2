<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\ContratoTrabalho;
use App\Models\Empresa;
use App\Models\Mensalidade;
use App\Notifications\EmpresaDeactivated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeactivateEmpresa
{

    /**
     * @param Empresa $empresa
     * @return bool
     */
    public static function handle(Empresa $empresa)
    {
        DB::beginTransaction();
        try {
            $empresa->status = 'cancelado';
            $empresa->save();

            /* @var Mensalidade $mensalidade */
            $mensalidade = $empresa->mensalidades()->latest()->first();
            $mensalidade->status = 'Cancelado';
            $mensalidade->save();

            //Notifica admins que existe um novo funcionario cadastrado
            $empresa->usuario->notify(new EmpresaDeactivated($empresa));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}