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
use App\Notifications\OrdemPagamentoNewStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateOrdemPagamento
{
    /**
     * @param Usuario $usuario
     * @param string $table
     * @param int $referencia
     * @param float $valor
     * @param \DateTime|null $vencimento
     * @return bool
     * @throws \Exception
     */
    public static function handle(Usuario $usuario, string $table, int $referencia, float $valor, \DateTime $vencimento = null)
    {
        if (!$vencimento) {
            $vencimento = date('Y-m-d H:i:s', strtotime("+7 day"));
        }
        DB::beginTransaction();
        try {
            /**
             * Cria ordem de pagamento para o usuário informado
             * @var OrdemPagamento $ordemPagamento
             * */
            $ordemPagamento = $usuario->ordensPagamento()->create(
                [
                    'referencia' => $table,
                    'id_referencia' => $referencia,
                    'valor' => $valor,
                    'vencimento' => $vencimento
                ]
            );

            //Notifica o usuário que existe uma nova ordem de pagamento
            $usuario->notify(new OrdemPagamentoCreated($ordemPagamento));

            //Notifica admins de uma nova ordem de pagamento
            Usuario::notifyAdmins(new OrdemPagamentoNewStatus($ordemPagamento));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            throw $e;
        }

        return true;
    }

}