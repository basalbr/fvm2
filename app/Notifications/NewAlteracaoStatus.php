<?php

namespace App\Notifications;

use App\Models\Alteracao;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewAlteracaoStatus extends Notification
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
            ->greeting('Olá '.$notifiable->nome.', tudo bem?')
            ->line('Temos novidades em seu processo de alteração!')
            ->line($this->alteracao->getNomeEtapa().': '.$this->alteracao->getDescricaoEtapa().'.')
            ->line('Para acompanhar seu processo é só clicar no botão abaixo.')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novidades em seu processo de alteração')
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
            'mensagem' => 'Temos novidades em seu processo de alteração!',
            'url' => $this->url
        ];
    }
}
