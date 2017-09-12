<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Admin\ApuracaoController;
use App\Models\Apuracao;
use App\Models\DocumentoContabil;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\OrdemPagamento;
use App\Models\Ponto;
use App\Models\ProcessoDocumentoContabil;
use App\Models\Usuario;
use App\Notifications\ApuracaoPending;
use App\Notifications\DocumentosContabeisPending;
use App\Notifications\PaymentAlmostPending;
use App\Notifications\PaymentPending;
use App\Services\ActivateEmpresa;
use App\Services\OpenPontosRequest;
use App\Services\SendMendalidadeAdjustment;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class CronController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dailyCron()
    {
        $this->verifyPendingPayments();
        $this->verifyApuracoesPending();
        $this->verifyDocumentosContabeisPending();
        $this->activateScheduledEmpresas();
    }

    /**
     * Verifica pagamentos com 3 ou mais dias de atraso e alerta os usuários que o pagamento está pendente
     */
    public function verifyPendingPayments()
    {
        $date = new DateTime('now');
        $date->sub(new DateInterval('P3D'));
        $pagamentos = OrdemPagamento::whereIn('status', ['Pendente','Cancelada'])->where('vencimento', '<', $date->format('Y-m-d'))->get();
        foreach ($pagamentos as $pagamento) {
            try {
                $pagamento->usuario->notify(new PaymentPending($pagamento));
            } catch (\Exception $e) {
                Log::critical($e);
            }
        }
    }

    public function activateScheduledEmpresas(){
        $today = Carbon::today()->format('Y-m-d');
        $empresas = Empresa::whereIn('status',['em_analise'])->where('ativacao_programada','<=',$today)->get();
        foreach($empresas as $empresa){
            /* @var Empresa $empresa */
            ActivateEmpresa::handle($empresa);
        }
    }

    public function openPontosRequest()
    {
//        if (date('d') == '01') {
        OpenPontosRequest::handle();
//        }
    }

    public function verifyAlmostPendingPayments()
    {
        $pagamentos = OrdemPagamento::whereIn('status', ['Pendente','Cancelada'])->where('vencimento', '>', '( CURDATE() - INTERVAL 3 DAY )')->get();

        foreach ($pagamentos as $pagamento) {
            try {
                $pagamento->usuario->notify(new PaymentAlmostPending($pagamento));
            } catch (\Exception $e) {
                Log::critical($e);
            }
        }
    }

    public function verifyApuracoesPending()
    {
        $date = new DateTime('now');
        $date->sub(new DateInterval('P3D'));
        $apuracoes = Apuracao::whereIn('status', ['novo', 'atencao'])->where('created_at', '<', $date->format('Y-m-d'))->groupBy(['id_empresa'])->select(['id_empresa'])->get();
        foreach ($apuracoes as $apuracao) {
            try {
                $apuracao->empresa->usuario->notify(new ApuracaoPending($apuracao->empresa));
            } catch (\Exception $e) {
                Log::critical($e);
            }
        }
    }

    public function verifyDocumentosContabeisPending()
    {
        $date = new DateTime('now');
        $date->sub(new DateInterval('P3D'));
        $documentosContabeis = ProcessoDocumentoContabil::whereIn('status', ['pendente', 'atencao'])->where('created_at', '<', $date->format('Y-m-d'))->groupBy(['id_empresa'])->select(['id_empresa'])->get();
        foreach ($documentosContabeis as $documentoContabil) {
            try {
                $documentoContabil->empresa->usuario->notify(new DocumentosContabeisPending($documentoContabil->empresa));
            } catch (\Exception $e) {
                Log::critical($e);
            }
        }
    }

    public function AdjustmentInMensalidade()
    {
        $usuarios = Usuario::all();
        SendMendalidadeAdjustment::handle($usuarios);
    }

}
