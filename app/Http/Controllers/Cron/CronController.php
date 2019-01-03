<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Cron;

use App\Mail\AgradecimentoRodadaNegocios;
use App\Models\Apuracao;
use App\Models\Empresa;
use App\Models\Mensagem;
use App\Models\OrdemPagamento;
use App\Models\ProcessoDocumentoContabil;
use App\Models\Usuario;
use App\Notifications\ApuracaoCritical;
use App\Notifications\ApuracaoPending;
use App\Notifications\DocumentosContabeisPending;
use App\Notifications\PaymentAlmostPending;
use App\Notifications\PaymentPending;
use App\Notifications\Sorry;
use App\Notifications\UsuarioDisabled;
use App\Services\ActivateEmpresa;
use App\Services\OpenPontosRequest;
use App\Services\SendMendalidadeAdjustment;
use App\Services\WarnMessageNotReadToAdmin;
use App\Services\WarnMessageNotReadToUser;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class CronController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dailyCron()
    {
        $this->verifyPendingPayments();
        $this->verifyApuracoesPending();
        $this->verifyDocumentosContabeisPending();
        $this->activateScheduledEmpresas();
        $this->notifyUnreadMessages();
    }

    /**
     * Verifica pagamentos com 3 ou mais dias de atraso e alerta os usuários que o pagamento está pendente
     */
    public function verifyPendingPayments()
    {
        $date = new DateTime('now');
        $date->sub(new DateInterval('P3D'));
        $pagamentos = OrdemPagamento::whereIn('status', ['Pendente'])->where('vencimento', '<', $date->format('Y-m-d'))->get();
        foreach ($pagamentos as $pagamento) {
            try {
                $pagamento->usuario->notify(new PaymentPending($pagamento));
            } catch (\Exception $e) {
                Log::info('Pagamento id: '.$pagamento->id);
                Log::critical($e);
            }
        }
    }

    public function notifyUnreadMessages()
    {
        $mensagens = Mensagem::where('lida', '=', 0)->where('referencia', '!=', 'chat')->groupBy('referencia', 'id_referencia', 'from_admin', 'id_usuario')->get(['referencia', 'id_referencia', 'from_admin', 'id_usuario']);
        foreach ($mensagens as $mensagem) {
            if ($mensagem->from_admin) {
                WarnMessageNotReadToUser::handle($mensagem);
            } else {
                WarnMessageNotReadToAdmin::handle($mensagem);
            }
        }
    }

    public function activateScheduledEmpresas()
    {
        $today = Carbon::today()->format('Y-m-d');
        $empresas = Empresa::whereIn('status', ['em_analise'])->where('ativacao_programada', '<=', $today)->get();
        foreach ($empresas as $empresa) {
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
        $pagamentos = OrdemPagamento::whereIn('status', ['Pendente', 'Cancelada'])->where('vencimento', '>', '( CURDATE() - INTERVAL 3 DAY )')->get();

        foreach ($pagamentos as $pagamento) {
            try {
                $pagamento->usuario->notify(new PaymentAlmostPending($pagamento));
            } catch (\Exception $e) {
                Log::info('Pagamento id: '.$pagamento->id);
                Log::critical($e);
            }
        }
    }

    public function verifyApuracoesPending()
    {
        $date = new DateTime('now');
        $date->sub(new DateInterval('P3D'));
        $apuracoes = Apuracao::whereIn('status', ['novo', 'atencao'])->where('created_at', '<', $date->format('Y-m-d'))->groupBy(['id_empresa'])->select(['id_empresa'])->get();
        $criticas = Apuracao::whereIn('status', ['novo', 'atencao'])->where('created_at', '<', $date->format('Y-m-d'))->get();
        foreach ($apuracoes as $apuracao) {
            try {
                $apuracao->empresa->usuario->notify(new ApuracaoPending($apuracao->empresa));
            } catch (\Exception $e) {
                Log::info('Apuração id: '.$apuracao->id);
                Log::critical($e);
            }
        }
        foreach ($criticas as $apuracao) {
            try {
                $diff = $apuracao->vencimento->diffInDays(Carbon::today());
                if ($diff <= 3 && $apuracao->vencimento->isFuture()) {
                    $apuracao->empresa->usuario->notify(new ApuracaoCritical($apuracao, $diff));
                }
            } catch (\Exception $e) {
                Log::info('Apuração id: '.$pagamento->id);
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
                Log::info('Contabilidade id: '.$documentoContabil->id);
                Log::critical($e);
            }
        }
    }

    public function AdjustmentInMensalidade()

    {
        $usuarios = Usuario::all();
        SendMendalidadeAdjustment::handle($usuarios);
    }

    public function sorry(){
        $usuarios = Usuario::whereHas('empresas', function($q){
            $q->where('deleted_at', null);
        })->orWhereHas('aberturasEmpresa', function($q){
            $q->where('deleted_at', null);
        })->get();
        foreach ($usuarios as $usuario) {
            try {
                $usuario->notify(new Sorry());
            } catch (\Exception $e) {
                Log::critical($e);
            }
        }
    }

    public function sendRodadaNegociosEmail()
    {
        $participantes = collect([['name' => 'Rodnei', 'email' => 'rodnei.almeida@sc.senac.br'],
                ['name' => 'Katiê', 'email' => 'katie@cadeviagens.net'],
                ['name' => 'Carlos', 'email' => 'Andreydinizrp@gmail.com '],
                ['name' => 'Jefferson', 'email' => 'jefferson.godoy@vilage.com.br'],
                ['name' => 'Rodrigo', 'email' => 'ponsoni@ponsoni.com.br'],
                ['name' => 'Fabíola', 'email' => 'FABIOLAMARIANA@HOTMAIL.COM'],
                ['name' => 'Arthur', 'email' => 'arthur_blu@hotmail.com'],
                ['name' => 'Alexandre', 'email' => 'alexandre@ideiaobjetiva.com.br'],
                ['name' => 'Junior Borges', 'email' => 'diretoria@premiumpartners.com.br'],
                ['name' => 'Lindomar', 'email' => 'jefferson.belissimo@gmail.com'],
                ['name' => 'Marcelo', 'email' => 'marcelo@a7b.com.br'],
                ['name' => 'Lilian', 'email' => 'lyly_meurer@yahoo.com.br'],
                ['name' => 'Sidnei', 'email' => 'Sidneia.cota@rogga.com.br'],
                ['name' => 'Eduardo', 'email' => 'eduardo@sorellaseguros.com.br'],
                ['name' => 'Uwe', 'email' => 'uwe@zelt.com.br'],
                ['name' => 'Jansle', 'email' => 'jansle@localcert.net.br'],
                ['name' => 'Salvino', 'email' => 'comercial@baher.com.br'],
                ['name' => 'Juliana', 'email' => 'juliana.cunha@plazahoteis.com.br'],
                ['name' => 'Carlos', 'email' => 'carlos.rogerio@nutrindoclub.com.br'],
                ['name' => 'Dan', 'email' => 'comercial@grupodm3.com.br'],
                ['name' => 'Ana', 'email' => 'vale@cerumar.com.br'],
                ['name' => 'Thomas', 'email' => 'thomas@tjwork.com.br'],
                ['name' => 'Vilma', 'email' => 'amoroacessorios@gmail.com'],
                ['name' => 'Jackson', 'email' => 'jackson@easyittraining.com.br'],
                ['name' => 'Daniela', 'email' => 'daniela@90fmblumenau.com.br'],
                ['name' => 'Giovanni', 'email' => 'Diretoria@7ases.com.br'],
                ['name' => 'Douglas', 'email' => 'ambientesobmedida@gmail.com'],
                ['name' => 'Alex', 'email' => 'contato@alexsoaresfilmes.com.br'],
                ['name' => 'Paulo', 'email' => 'paulo.soares@paros.com.br'],
                ['name' => 'Rodrigo', 'email' => 'administracao02@gruporivage.com.br'],
                ['name' => 'Eliseu', 'email' => 'comercial@aguiarconsultoria.com'],
                ['name' => 'Allan', 'email' => 'allan@onlince.com.br'],
                ['name' => 'Bruno', 'email' => 'mastersetteatd@gmail.com'],
                ['name' => 'Alex', 'email' => 'alexreparabrisa@bol.com.br'],
                ['name' => 'Renato', 'email' => 'renato.deus@rdseguranca.com.br'],
                ['name' => 'Fabio', 'email' => 'fabiosilvaimoveis3@gmail.com'],
                ['name' => 'João', 'email' => 'Taumaturgobnu@gmail.com '],
                ['name' => 'Valmir', 'email' => 'valmir@graficakasburg.com.br'],
                ['name' => 'Deise', 'email' => 'demarch_diversoes@hotmail.com'],
                ['name' => 'Rodrigo', 'email' => 'rodrigo@omunicipioblumenau.com.br'],
                ['name' => 'Leonardo', 'email' => 'leonardo.casas@onlysolution.com.br'],
                ['name' => 'Andreza', 'email' => 'Financeiro@topquadros.com.br'],
                ['name' => 'Alexandre', 'email' => 'Alexandre@correparti-sc.com.br'],
                ['name' => 'Rogério', 'email' => 'rogerio@maxintec.com.br'],
                ['name' => 'Ênio', 'email' => 'enioservice@gmail.com'],
                ['name' => 'Sacha', 'email' => 'sacha@hfdeco.com.br'],
                ['name' => 'Gerson', 'email' => 'gersonrmedeiros@gmail.com'],
                ['name' => 'Ricardo', 'email' => 'ricardo@brgweb.com.br'],
                ['name' => 'Daniele', 'email' => 'Daniele.volpi@ganhejuntoeconomias.com.br'],
                ['name' => 'Maria Cristina', 'email' => 'mendofit@hotmail.com'],
                ['name' => 'Thiago', 'email' => 'Executivo@knowhowtreinamentos.com.br'],
                ['name' => 'Paulo', 'email' => 'paulo@perfilrevista.com.br'],
                ['name' => 'Norton', 'email' => 'norton.rosa@somosnsc.com.br'],
                ['name' => 'Alexandre', 'email' => 'Alexandra@dresslike.moda'],
                ['name' => 'João', 'email' => 'joao@grupocomunique.com'],
                ['name' => 'Lucas', 'email' => 'lucas@innovamkt.com.br'],
                ['name' => 'Paulo', 'email' => 'paulo_piske@outlook.com '],
                ['name' => 'Ramon', 'email' => 'greenplacesk8@gmail.com'],
                ['name' => 'Rui', 'email' => 'ruireinert@gmail.com'],
                ['name' => 'Moacir', 'email' => 'comercial@jfcdivulgacoes.com.br'],
                ['name' => 'Jackeline', 'email' => 'Jackhawa@gmail.com']]
        );
        foreach ($participantes as $participante) {
            try {
                Mail::to($participante['email'])->send(new AgradecimentoRodadaNegocios($participante['name']));
            } catch (\Exception $e) {
                Log::critical($e);
            }
        }
    }

}
