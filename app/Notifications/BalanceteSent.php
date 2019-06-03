<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BalanceteSent extends Notification implements ShouldQueue
{
    use Queueable;
    private $exercicio;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param string $exercicio
     */
    public function __construct(string $exercicio)
    {
        $this->exercicio = $exercicio;
        $this->url = route('listBalancetesToUser');
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
            ->greeting('Olá '.$notifiable->nome.'!')
            ->line('Já está disponível o balancete referente ao exercício de '.$this->exercicio.'.')
            ->line('Para visualizar os seus balancetes, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('Att,                
                WEBContabilidade :)')
            ->subject('Novo balancete disponível')
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
            'mensagem' => 'Já está disponível o balancete referente ao exercício de '.$this->exercicio.'.',
            'url' => $this->url
        ];
    }
}
