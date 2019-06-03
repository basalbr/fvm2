<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageFromSite extends Notification implements ShouldQueue
{
    use Queueable;
    private $mensagem;

    /**
     * MessageFromSite constructor.
     * @param $mensagem
     */
    public function __construct($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->line($this->mensagem->get('mensagem'))
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo contato do site')
            ->from($this->mensagem->get('email'), $this->mensagem->get('nome'));
    }

}
