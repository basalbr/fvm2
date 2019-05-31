<?php

namespace App\Notifications;

use App\Models\Mensagem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminHasUnreadMessages extends Notification
{
    use Queueable;

    private $mensagem;
    private $url;

    /**
     * MessageSent constructor.
     * @param Mensagem $mensagem
     * @param $admin
     */
    public function __construct(Mensagem $mensagem)
    {
        $this->mensagem = $mensagem;
        if ($this->mensagem->referencia == 'chamado') {
            $this->url = route('showChamadoToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'abertura_empresa') {
            $this->url = route('showAberturaEmpresaToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'empresa') {
            $this->url = route('showEmpresaToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'apuracao') {
            $this->url = route('showApuracaoToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'alteracao') {
            $this->url = route('showSolicitacaoAlteracaoToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'processo_folha') {
            $this->url = route('showProcessoFolhaToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'processo_documento_contabil') {
            $this->url = route('showDocumentoContabilToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'funcionario') {
            $this->url = route('showFuncionarioToAdmin', [$this->mensagem->parent->id_empresa, $this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'demissao') {
            $this->url = route('showDemissaoToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'alteracao_contratual') {
            $this->url = route('showAlteracaoContratualToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'ponto') {
            $this->url = route('showPontoToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'imposto_renda') {
            $this->url = route('showImpostoRendaToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'decimo_terceiro') {
            $this->url = route('showDecimoTerceiroToAdmin', [$this->mensagem->id_referencia]);
        }
        if ($this->mensagem->referencia == 'recalculo') {
            $this->url = route('showRecalculoToAdmin', [$this->mensagem->id_referencia]);
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Olá ' . $notifiable->nome . '!')
            ->line('Possuímos mensagens não lidas ' . $this->getDescricao() . '.')
            ->line('Para ver essas mensagens, clique no botão abaixo.')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Mensagens não lidas')
            ->from('site@webcontabilidade.com', 'WEBContabilidade');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'mensagem' => 'Possuímos mensagens não lidas ' . $this->getDescricao() . '.',
            'url' => $this->url
        ];
    }

    public function getDescricao()
    {
        if ($this->mensagem->referencia == 'chamado') {
            return 'no chamado ' . $this->mensagem->parent->tipoChamado->descricao;
        }
        if ($this->mensagem->referencia == 'abertura_empresa') {
            return 'na abertura de empresa (' . $this->mensagem->parent->nome_empresarial1 . ')';
        }
        if ($this->mensagem->referencia == 'empresa') {
            return 'na empresa (' . $this->mensagem->parent->razao_social . ')';
        }
        if ($this->mensagem->referencia == 'apuracao') {
            return 'na apuração de ' . $this->mensagem->parent->imposto->nome . ' (' . $this->mensagem->parent->competencia->format('m/Y') . ') da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'alteracao') {
            return 'na solicitação de alteração (' . $this->mensagem->parent->tipo->descricao . ') da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'processo_folha') {
            return 'na apuração de folha de pagamento (' . $this->mensagem->parent->competencia->format('m/Y') . ') da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'processo_documento_contabil') {
            return 'na apuração de documentos contábeis (' . $this->mensagem->parent->periodo->format('m/Y') . ') da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'funcionario') {
            return 'no funcionário ' . $this->mensagem->parent->nome_completo . ' da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'demissao') {
            return 'na solicitação de demissão do funcionário '.$this->mensagem->parent->funcionario->nome_completo.' da empresa '.$this->mensagem->parent->funcionario->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'alteracao_contratual') {
            return 'na solicitação de alteração contratual do funcionário '.$this->mensagem->parent->funcionario->nome_completo.' da empresa '.$this->mensagem->parent->funcionario->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'ponto') {
            return 'no registro de ponto da empresa '.$this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'imposto_renda') {
            return 'no imposto de renda de '.$this->mensagem->parent->nome;
        }
        if ($this->mensagem->referencia == 'decimo_terceiro') {
            return 'no décimo terceiro da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'recalculo') {
            return 'no recálculo ' . $this->mensagem->parent->tipo->descricao .' do usuário '.$this->mensagem->parent->usuario->nome;
        }
        return 'em um processo';
    }

}
