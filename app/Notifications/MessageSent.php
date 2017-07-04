<?php

namespace App\Notifications;

use App\Models\Mensagem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MessageSent extends Notification
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
            if ($this->mensagem->referencia == 'processo_documento_contabil') {
                $this->url = route('showDocumentoContabilToAdmin', [$this->mensagem->id_referencia]);
            }
        }elseif(!$admin) {
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
            if ($this->mensagem->referencia == 'processo_documento_contabil') {
                $this->url = route('showDocumentoContabilToUser', [$this->mensagem->id_referencia]);
            }
        }else{
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
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Olá!')
            ->line('Você recebeu uma nova mensagem em nosso site.')
            ->line('Clique no botão abaixo para visualizar.')
            ->action('Visualizar Mensagem', $this->url)
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
            'mensagem' => 'Você recebeu uma nova mensagem em um processo de abertura de empresa.',
            'url' => $this->url
        ];
    }

}
