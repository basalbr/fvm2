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
use App\Models\Mensalidade;
use App\Models\OrdemPagamento;
use App\Models\ProcessoDocumentoContabil;
use App\Models\Usuario;
use App\Notifications\ApuracaoCritical;
use App\Notifications\ApuracaoPending;
use App\Notifications\DocumentosContabeisPending;
use App\Notifications\NewStatusApuracao;
use App\Notifications\PaymentAlmostPending;
use App\Notifications\PaymentPending;
use App\Notifications\ReajusteMensalidade;
use App\Notifications\Sorry;
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

    private function mb_str_pad($input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT)
    {
        $diff = strlen($input) - mb_strlen($input);
        return str_pad($input, $pad_length + $diff, $pad_string, $pad_type);
    }

    public function nfs()
    {
        $start = new Carbon('first day of last month');
        $end = new Carbon('last day of last month');
        $pagamentos = OrdemPagamento::where('referencia', 'mensalidade')->where('valor','>',0)->where('status', 'Paga')->whereBetween('vencimento', [$start, $end])->get();
        $rps = '1002' . $this->mb_str_pad('121537', 15, '0', 0) . date('Ymd') . date('Ymd') . chr(13) . chr(10);
        $valorTotal = 0.0;
        $qtdNotas = 0;
        foreach ($pagamentos as $pagamento) {
            /*@var OrdemPagamento $pagamento*/
            $valorTotal += $pagamento->valor;
            $qtdNotas++;
            $rps .= '20     ' . self::mb_str_pad($pagamento->id, 15, '0', 0)
                . date('Ymd') . 'T'
                . self::mb_str_pad(preg_replace('/\D/', '', number_format($pagamento->valor, 2)), 15, '0', 0)
                . self::mb_str_pad('0', 15, '0', 0)
                . self::mb_str_pad('1719', 8, '0', 0)
                . self::mb_str_pad('200', 5, '0', 0)
                . '0'
                . '2'
                . self::mb_str_pad(preg_replace('/\D/', '', $pagamento->parent->empresa->cnpj), 14, '0', 0)
                . self::mb_str_pad('', 15, '0', 0)
                . self::mb_str_pad('', 15, '0', 0)
                . self::mb_str_pad(trim($pagamento->parent->empresa->razao_social), 115, ' ')
                . self::mb_str_pad(trim($pagamento->parent->empresa->endereco), 103, ' ')
                . self::mb_str_pad(trim($pagamento->parent->empresa->numero), 10, ' ')
                . self::mb_str_pad(trim($pagamento->parent->empresa->complemento), 60, ' ')
                . self::mb_str_pad(trim($pagamento->parent->empresa->bairro), 72, ' ')
                . self::mb_str_pad(trim($pagamento->parent->empresa->cidade), 50, ' ')
                . self::mb_str_pad(trim($pagamento->parent->empresa->uf->sigla), 2, ' ')
                . self::mb_str_pad(preg_replace('/\D/', '', $pagamento->parent->empresa->cep), 8, ' ')
                . self::mb_str_pad(trim($pagamento->parent->empresa->usuario->email), 80, ' ')
                . self::mb_str_pad('0', 15, ' ')
                . self::mb_str_pad('0', 15, ' ')
                . self::mb_str_pad('0', 15, ' ')
                . self::mb_str_pad('0', 15, ' ')
                . self::mb_str_pad('0', 15, ' ')
                . 'Serviços prestados entre ' . $start->format('d/m/Y') . ' e ' . $end->format('d/m/Y')
                . chr(13) . chr(10);
        }
        $rps .= '9' . $this->mb_str_pad($qtdNotas, 7, '0', 0)
            . $this->mb_str_pad(preg_replace('/\D/', '', number_format($valorTotal, 2)), 15, '0', 0)
            . $this->mb_str_pad('0', 15, ' ')
            . $this->mb_str_pad('0', 15, ' ')
            . $this->mb_str_pad('0', 15, ' ')
            . $this->mb_str_pad('0', 15, ' ')
            . $this->mb_str_pad('0', 15, ' ')
            . $this->mb_str_pad('0', 15, ' ')
            . $this->mb_str_pad('0', 15, ' ')
            . chr(13) . chr(10);
//    dd($valorTotal);
        return response($rps)->withHeaders([
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'attachment; filename="logs.txt',
        ]);
        echo $rps;
    }

    /**
     * Altera as apuracoes para sem movimento
     */
    public function changeApuracaoToSemMovimento()
    {
        $apuracoes = Apuracao::where('status', 'novo')->get();
        foreach ($apuracoes as $apuracao) {
            try {
                $apuracao->status = 'sem_movimento';
                $apuracao->save();
                $apuracao->empresa->usuario->notify(new NewStatusApuracao($apuracao));
            } catch (\Exception $e) {
                Log::info('nao foi possivel alterar para sem movimento a apuracao:' . $apuracao->id);
            }
        }
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
                Log::info('Pagamento id: ' . $pagamento->id);
                Log::critical($e);
            }
        }
    }

    public function notifyUnreadMessages()
    {
        try {
            if (!$this->isTodayWeekend()) {
                $mensagens = Mensagem::where('lida', '=', 0)->where('created_at', '>=', Carbon::now()->subDays(90))->get();
                $enviadas = [];
                foreach ($mensagens as $mensagem) {
                    $is_enviada = false;
                    if (count($enviadas)) {
                        foreach ($enviadas as $enviada) {
                            if ($enviada == ['id_referencia' => $mensagem->id_referencia, 'referencia' => $mensagem->referencia, 'from_admin' => $mensagem->from_admin]) {
                                $is_enviada = true;
                            }
                        }
                    }
                    if (!$is_enviada) {
                        $mensagem->from_admin ? WarnMessageNotReadToUser::handle($mensagem) : WarnMessageNotReadToAdmin::handle($mensagem);
                        $enviadas[] = ['id_referencia' => $mensagem->id_referencia, 'referencia' => $mensagem->referencia, 'from_admin' => $mensagem->from_admin];
                    }
                }
            } else {
                Log::info('mensagens não enviadas pois é final de semana');
                return false;
            }
        } catch (\Exception $e) {
            Log::critical($mensagem->id);
            Log::critical($e);
        }
        Log::info('mensagens não lidas enviadas com sucesso');
        return true;
    }

    // For the current date
    private function isTodayWeekend()
    {
        $dt = Carbon::now();
        return $dt->isWeekend();
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
                Log::info('Pagamento id: ' . $pagamento->id);
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
                Log::info('apuracao pendente empresa:' . $apuracao->empresa->razao_social);
            } catch (\Exception $e) {
                Log::info('Apuração id: ' . $apuracao->id);
                Log::critical($e);
            }
        }
        foreach ($criticas as $apuracao) {
            try {
                $diff = $apuracao->vencimento->subDays(4)->diffInDays(Carbon::today());
                if ($diff <= 5 && $apuracao->vencimento->isFuture()) {
                    $apuracao->empresa->usuario->notify(new ApuracaoCritical($apuracao, $diff));
                }
                Log::info('apuracao critica empresa:' . $apuracao->empresa->razao_social);
            } catch (\Exception $e) {
                Log::info('Apuração id: ' . $apuracao->id);
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
                Log::info('Contabilidade id: ' . $documentoContabil->id);
                Log::critical($e);
            }
        }
    }

    public function AdjustmentInMensalidade()

    {
        $usuarios = Usuario::all();
        SendMendalidadeAdjustment::handle($usuarios);
    }

    public function sorry()
    {
        $usuarios = Usuario::whereHas('empresas', function ($q) {
            $q->where('deleted_at', null);
        })->orWhereHas('aberturasEmpresa', function ($q) {
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

    public function reajusteMensalidade()
    {
        $empresas = Empresa::where('status', 'aprovado')->get();
        foreach ($empresas as $empresa) {
            try {
                /* @var Empresa $empresa */

                if ($empresa->getMensalidadeAtual()->valor < Mensalidade::calculateMonthlyPayment($empresa->getMensalidadeAtual())) {
                    echo 'Empresa ' . $empresa->id . ' - ' . $empresa->getMensalidadeAtual()->valor . ' - ' . Mensalidade::calculateMonthlyPayment($empresa->getMensalidadeAtual()) . '<br />';
                    $mensalidadeAtual = $empresa->getMensalidadeAtual();
                    $mensalidadeAtual->valor = Mensalidade::calculateMonthlyPayment($empresa->getMensalidadeAtual());
                    $mensalidadeAtual->save();
//                    $empresa->usuario->notify(new ReajusteMensalidade($empresa->getMensalidadeAtual(), Mensalidade::calculateMonthlyPayment($empresa->getMensalidadeAtual())));
                }
            } catch (\Exception $e) {
                Log::critical('Não foi possível enviar a mensagem de reajuste para empresa ' . $empresa->id);
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
