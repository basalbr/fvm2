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
use App\Models\OrdemPagamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use League\Flysystem\Exception;

class AberturaEmpresaObserver
{
    /**
     * Listen to the AberturaEmpresa created event.
     *
     * @param  AberturaEmpresa $aberturaEmpresa
     * @return void
     */
    public function created(AberturaEmpresa $aberturaEmpresa)
    {
        $usuario = $aberturaEmpresa->usuario;
        DB::beginTransaction();
        try {
            $this->createOrdemPagamento($aberturaEmpresa);
            //Sends e-mail to admin informing the event
            Mail::send('emails.nova-abertura-empresa-admin', ['nome' => $usuario->nome, 'id_empresa' => $this->id], function ($m) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject('Nova Solicitação de Abertura de Empresa');
            });
            //Sends e-mail to the user to confirm the event
            Mail::send(new AberturaEmpresaCreated($aberturaEmpresa));

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
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
