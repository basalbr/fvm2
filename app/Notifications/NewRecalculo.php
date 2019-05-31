<?php

namespace App\Notifications;

use App\Models\Recalculo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewRecalculo extends Notification
{
    use Queueable;
    private $recalculo;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Recalculo $recalculo
     */
    public function __construct(Recalculo $recalculo)
    {
        $this->recalculo = $recalculo;
        $this->url = route('showRecalculoToAdmin', [$this->recalculo->id]);
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
            ->line('Temos um nova solicitação de recálculo ' . $this->recalculo->tipo->descricao)
            ->line('Para visualizar essa solicitação, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo Recálculo')
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
            'mensagem' =>'Temos um nova solicitação de recálculo ' . $this->recalculo->tipo->descricao,
            'url' => $this->url
        ];
    }
}
