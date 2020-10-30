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
use Carbon\Carbon;
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
use PagSeguro\Services\Transactions\Search\Reference;

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

                $ordemPagamento = OrdemPagamento::findOrFail($ordemPagamentoId);
                if ($ordemPagamento->status == 'Paga' || $ordemPagamento->status == 'Disponível') {
                    return true;
                }
                $ordemPagamento->status = $status;
                $ordemPagamento->valor_pago = $response->getGrossAmount();
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
            Log::critical('Erro notificacao pagseguro:'. $e);
            Log::critical(var_dump($_POST));
            return response('Ocorreu um erro, verifique o log', 500);
        }
    }

    public function checkPayments(){
        $pagamentos = OrdemPagamento::where('status', 'Pendente')->where('created_at', '>=', Carbon::now()->subDays(30))->get();
        $nomeStatus = [
            1 => 'Aguardando pagamento',
            2 => 'Em análise',
            3 => 'Paga',
            4 => 'Disponível',
            5 => 'Em disputa',
            6 => 'Devolvida',
            7 => 'Cancelada'
        ];
        $options = [
            'initial_date' => Carbon::now()->subDays(7)->format('Y-m-d') . 'T00:00'
        ];
        foreach($pagamentos as $pagamento){

            $reference = $pagamento->id;
            try {
                $response = Reference::search(
                    Configure::getAccountCredentials(),
                    $reference,
                    $options
                );

                if($response->getTransactions() !== null){
                    $transaction = $response->getTransactions()[0];
                    echo $pagamento->id.'-'.$pagamento->status.'<br />';
                    $transactionId = $transaction->getCode();
                    $status = $nomeStatus[$transaction->getStatus()];
                    if (!in_array($pagamento->status, ['Paga', 'Disponível'])) {
                        $pagamento->status = $status;
                        $pagamento->valor_pago = $transaction->getGrossAmount();
                        $pagamento->save();

                        $historicoPagamento = new HistoricoPagamento;
                        $historicoPagamento->id_ordem_pagamento = $pagamento->id;
                        $historicoPagamento->transaction_id = $transactionId;
                        $historicoPagamento->status = $status;
                        $historicoPagamento->save();
                        $pagamento->usuario->notify(new OrdemPagamentoNewStatusUsuario($pagamento));
                    }

                }
            } catch (Exception $e) {
                Log::critical('Busca do pagseguro:');
                Log::critical($e);
            }
        }
    }
}
