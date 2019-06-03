<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApuracaoPending extends Notification implements ShouldQueue
{
    use Queueable;
    private $url;
    private $empresa;

    /**
     */
    public function __construct($empresa)
    {
        $this->empresa = $empresa;
        $this->url = route('listApuracoesToUser');
    }

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
            ->greeting('Olá ' . $this->empresa->usuario->nome.'!')
            ->line('Verificamos que existem apurações em aberto no nosso sistema que requerem sua atenção.')
            ->line('Para verificar essas apurações, clique no botão abaixo:')
            ->action('Verificar Apurações', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Apurações pendentes')
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
            'mensagem' => 'Verificamos que existem apurações em aberto no nosso sistema que requerem sua atenção.',
            'url' => $this->url
        ];
    }
}
