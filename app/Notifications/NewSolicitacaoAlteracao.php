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
        $this->url = route('showSolicitacaoAlteracaoToUser', [$this->alteracao->id]);
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
            ->line('Temos uma nova solicitação de '.$this->alteracao->tipo->descricao.' de ' . $this->alteracao->usuario->nome)
            ->line('Para visualizar essa solicitação, clique no botão abaixo:')
            ->action('Visualizar Solicitação', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo solicitação de '.$this->alteracao->tipo->descricao)
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
            'mensagem' => $this->alteracao->usuario->nome.' abriu um novo alteracao!',
            'url' => $this->url
        ];
    }
}
