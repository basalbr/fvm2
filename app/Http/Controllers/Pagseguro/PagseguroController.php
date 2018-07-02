<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Pagseguro;

use App\Models\HistoricoPagamento;
use App\Models\OrdemPagamento;
use App\Models\Usuario;
use App\Notifications\OrdemPagamentoNewStatusAdmin;
use App\Notifications\OrdemPagamentoNewStatusUsuario;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use PagSeguro\Configuration\Configure;
use PagSeguro\Helpers\Xhr;
use PagSeguro\Library;
use PagSeguro\Services\Transactions\Notification;

class PagseguroController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     *
     */
    public function notifications()
    {
        header("access-control-allow-origin: https://www.pagseguro.uol.com.br");
        try {
            if (Xhr::hasPost()) {
                $nomeStatus = [
                    1 => 'Aguardando pagamento',
                    2 => 'Em análise',
                    3 => 'Paga',
                    4 => 'Disponível',
                    5 => 'Em disputa',
                    6 => 'Devolvida',
                    7 => 'Cancelada'
                ];
                $response = Notification::check(
                    Configure::getAccountCredentials()
                );

                $ordemPagamentoId = $response->getReference();
                $transactionId = $response->getCode();
                $status = $nomeStatus[$response->getStatus()];

                $ordemPagamento = OrdemPagamento::find($ordemPagamentoId);
                if($ordemPagamento->status == 'Paga' || $ordemPagamento->status == 'Disponível'){
                    return true;
                }
                $ordemPagamento->status = $status;
                $ordemPagamento->save();

                $historicoPagamento = new HistoricoPagamento;
                $historicoPagamento->id_ordem_pagamento = $ordemPagamentoId;
                $historicoPagamento->transaction_id = $transactionId;
                $historicoPagamento->status = $status;
                $historicoPagamento->save();

                $ordemPagamento->usuario->notify(new OrdemPagamentoNewStatusUsuario($ordemPagamento));
//                Usuario::notifyAdmins(new OrdemPagamentoNewStatusAdmin($ordemPagamento));

            } else {
                throw new \InvalidArgumentException($_POST);
            }
        } catch (Exception $e) {
            Log::critical($e);
        }
    }


}
