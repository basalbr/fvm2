<?php

namespace App\Notifications;

use App\Models\Alteracao;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewSolicitacaoAlteracao extends Notification
{
    use Queueable;
    private $alteracao;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Alteracao $alteracao
     */
    public function __construct(Alteracao $alteracao)
    {
        $this->alteracao = $alteracao;
        $this->url = route('showSolicitacaoAlteracaoToAdmin', [$this->alteracao->id]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
            ->line('Temos uma nova solicitação de alteração de ' . $this->alteracao->empresa->razao_social.'.')
            ->line('Para visualizar essa solicitação, clique no botão abaixo:')
            ->action('Visualizar Solicitação', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Nova solicitação de alteração')
            ->from('site@webcontabilidade.com', 'WEBContabilidade');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'mensagem' => 'Temos uma nova solicitação de alteração de ' . $this->alteracao->usuario->nome,
            'url' => $this->url
        ];
    }
}
