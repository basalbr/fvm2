<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KilledByInadimplency extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
            ->greeting('Olá ' . $notifiable->nome.'!')
            ->line('Estamos encerrando nosso contrato com você pelo motivo de inadimplência com nossa empresa.')
            ->line("Caso acredite que esse e-mail seja um erro ou precise de maiores detalhes, basta entrar em contato através do e-mail: contato@webcontabilidade.")
            ->salutation('Agradecemos o tempo que esteve conosco e desejamos sucesso em suas empreitadas.')
            ->subject('Serviços encerrados')
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
            'mensagem' => 'Estamos encerrando nosso contrato com você pelo motivo de inadimplência com nossa empresa.'
        ];
    }
}
