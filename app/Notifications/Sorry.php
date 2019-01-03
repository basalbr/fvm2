<?php

namespace App\Notifications;

use App\Models\OrdemPagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class Sorry extends Notification
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
            ->greeting('Olá ' . $notifiable->nome . '!')
            ->line('Queremos agradecer você pela parceria com nossa equipe nesse ano que passou e dizer que você tem sido uma peça chave no sucesso da nossa caminhada.')
            ->line('Saiba '.$notifiable->nome.' que estamos preparados e à sua disposição para enfrentar os mais diversos desafios que a ação de empreender nos traz.')
            ->line('Desejamos um feliz natal e um próspero ano novo e que em 2019 possamos fortalecer nossa parceria para que juntos tenhamos um ano repleto de conquistas e de sucesso.')
            ->salutation('Esses são os mais sinceros votos da equipe WEBContabilidade :)')
            ->subject('Feliz Natal e Próspero Ano Novo')
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
            'mensagem' => 'Verificamos que existem apurações em aberto no nosso sistema que requerem sua atenção.'
        ];
    }
}
