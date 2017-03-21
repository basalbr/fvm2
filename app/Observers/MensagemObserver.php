<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 16/03/2017
 * Time: 21:05
 */

namespace Observers;


use App\Mail\AberturaEmpresaCreated;
use App\Models\AberturaEmpresa;
use App\Models\Mensagem;
use App\Models\OrdemPagamento;
use App\Models\Usuario;
use App\Notifications\MessageSent;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use League\Flysystem\Exception;

class MensagemObserver
{
    /**
     * Listen to the AberturaEmpresa created event.
     *
     * @param  Mensagem $mensagem
     * @return void
     */
    public function created(Mensagem $mensagem)
    {
        if ($mensagem->origem == 'usuario') {
            $mensagem->usuario->notify(new MessageSent($mensagem));
        }else{
            Notification::send(Usuario::admins(), new MessageSent($mensagem));
        }
    }

    /**
     * Listen to the AberturaEmpresa deleting event.
     *
     * @param  AberturaEmpresa $aberturaEmpresa
     * @return void
     */
    public function deleting(AberturaEmpresa $aberturaEmpresa)
    {
        //Cascade relationships
        DB::beginTransaction();
        try {
            $aberturaEmpresa->ordemPagamento->delete();
            $aberturaEmpresa->socio->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    private function createOrdemPagamento(AberturaEmpresa $aberturaEmpresa)
    {
        try {
            $pagamento = new OrdemPagamento;
            $pagamento->tipo = $aberturaEmpresa->getTable();
            $pagamento->id_abertura_empresa = $aberturaEmpresa->id;
            $pagamento->valor = WebContabilidade::getValorAberturaEmpresa();
            $pagamento->vencimento = WebContabilidade::getVencimentoPagamentoAberturaEmpresa();
            $pagamento->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }


}
