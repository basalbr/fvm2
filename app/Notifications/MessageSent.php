<?php

namespace App\Notifications;

use App\Models\Mensagem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MessageSent extends Notification implements ShouldQueue
{
    use Queueable;

    private $mensagem;
    private $url;

    /**
     * MessageSent constructor.
     * @param Mensagem $mensagem
     * @param $admin
     */
    public function __construct(Mensagem $mensagem, $admin)
    {
        $this->mensagem = $mensagem;
        if ($admin) {
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
            if ($this->mensagem->referencia == 'ponto') {
                $this->url = route('showPontoToAdmin', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'alteracao_contratual') {
                $this->url = route('showAlteracaoContratualToAdmin', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'decimo_terceiro') {
                $this->url = route('showDecimoTerceiroToAdmin', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'imposto_renda') {
                $this->url = route('showImpostoRendaToAdmin', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'recalculo') {
                $this->url = route('showRecalculoToAdmin', [$this->mensagem->id_referencia]);
            }
        } elseif (!$admin) {
            if ($this->mensagem->referencia == 'chamado') {
                $this->url = route('viewChamado', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'abertura_empresa') {
                $this->url = route('showAberturaEmpresaToUser', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'empresa') {
                $this->url = route('showEmpresaToUser', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'apuracao') {
                $this->url = route('showApuracaoToUser', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'alteracao') {
                $this->url = route('showSolicitacaoAlteracaoToUser', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'processo_folha') {
                $this->url = route('showProcessoFolhaToUser', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'processo_documento_contabil') {
                $this->url = route('showDocumentoContabilToUser', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'funcionario') {
                $this->url = route('showFuncionarioToUser', [$this->mensagem->parent->id_empresa, $this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'demissao') {
                $this->url = route('showDemissaoToUser', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'ponto') {
                $this->url = route('showPontoToUser', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'alteracao_contratual') {
                $this->url = route('showAlteracaoContratualToUser', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'decimo_terceiro') {
                $this->url = route('showDecimoTerceiroToUser', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'imposto_renda') {
                $this->url = route('showImpostoRendaToUser', [$this->mensagem->id_referencia]);
            }
            if ($this->mensagem->referencia == 'recalculo') {
                $this->url = route('showRecalculoToUser', [$this->mensagem->id_referencia]);
            }
        } else {
            $this->url = null;
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
            ->greeting('Olá!')
            ->line('Você recebeu uma mensagem de ' . $this->mensagem->usuario->nome . ' referente ' . $this->getDescricao() . '.')
            ->line('Clique no botão abaixo para visualizar essa mensagem.')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Você recebeu uma nova mensagem')
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
            'mensagem' => 'Você recebeu uma mensagem de ' . $this->mensagem->usuario->nome . ' referente ' . $this->getDescricao() . '.',
            'url' => $this->url
        ];
    }

    public function getDescricao()
    {
        if ($this->mensagem->referencia == 'chamado') {
            return 'ao chamado (' . $this->mensagem->parent->tipoChamado->descricao . ') de ' . $this->mensagem->parent->usuario->nome;
        }
        if ($this->mensagem->referencia == 'abertura_empresa') {
            return 'à abertura de empresa (' . $this->mensagem->parent->nome_empresarial1 . ')';
        }
        if ($this->mensagem->referencia == 'empresa') {
            return 'à ' . $this->mensagem->parent->razao_social;
        }
        if ($this->mensagem->referencia == 'apuracao') {
            return 'à apuração de ' . $this->mensagem->parent->imposto->nome . ' (' . $this->mensagem->parent->competencia->format('m/Y') . ') da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'alteracao') {
            return 'à solicitação de alteração (' . $this->mensagem->parent->tipo->descricao . ') da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'processo_folha') {
            return 'à apuração de folha de pagamento (' . $this->mensagem->parent->competencia->format('m/Y') . ') da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'processo_documento_contabil') {
            return 'à apuração de documentos contábeis (' . $this->mensagem->parent->periodo->format('m/Y') . ') da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'funcionario') {
            return 'ao funcionário ' . $this->mensagem->parent->nome_completo . ' da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'demissao') {
            return 'à solicitação de demissão do funcionário ' . $this->mensagem->parent->funcionario->nome_completo . ' da empresa ' . $this->mensagem->parent->funcionario->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'ponto') {
            return 'ao processo de envio de folha de ponto dos funcionários da empresa ' . $this->mensagem->parent->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'alteracao_contratual') {
            return 'à solicitação de alteração contratual do funcionário ' . $this->mensagem->parent->funcionario->nome_completo . ' da empresa ' . $this->mensagem->parent->funcionario->empresa->razao_social;
        }
        if ($this->mensagem->referencia == 'decimo_terceiro') {
            return 'ao décimo terceiro da empresa ' . $this->mensagem->parent->empresa->nome_fantasia;
        }
        if ($this->mensagem->referencia == 'imposto_renda') {
            return 'no imposto de renda de '.$this->mensagem->parent->nome;
        }
        if ($this->mensagem->referencia == 'recalculo') {
            return 'ao recálculo ' . $this->mensagem->parent->tipo->descricao;
        }
        return 'à um processo';
    }

}
