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

class CreateOrdemPagamento
{
    /**
     * @param string $table
     * @param int $referencia
     * @param float $valor
     * @param Usuario $usuario
     * @param \DateTime|null $vencimento
     * @return bool
     */
    public static function handle(Usuario $usuario, string $table, int $referencia, double $valor, \DateTime $vencimento = null)
    {
        if (!$vencimento) {
            $vencimento = date('Y-m-d H:i:s', strtotime("+7 day"));
        }
        DB::beginTransaction();
        try {
            $ordemPagamento = $usuario->ordensParamento()->create(
                [
                    'tipo' => $table,
                    'id_referencia' => $referencia,
                    'valor' => $valor,
                    'vencimento' => $vencimento
                ]
            );
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        $usuario->notify(new OrdemPagamentoCreated($ordemPagamento));
        return true;
    }

}