<?php

namespace App\Notifications;

use App\Models\Chamado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewChamado extends Notification implements ShouldQueue
{
    use Queueable;
    private $chamado;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Chamado $chamado
     */
    public function __construct(Chamado $chamado)
    {
        $this->chamado = $chamado;
        $this->url = route('showChamadoToAdmin', [$this->chamado->id]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($notifiable->admin === 1 && $notifiable->id !== 1){
            return ['database'];
        }
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
            ->line('Temos um novo chamado de ' . $this->chamado->usuario->nome)
            ->line('Para visualizar essa solicitação, clique no botão abaixo:')
            ->action('Visualizar Chamado', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo chamado')
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
            'mensagem' => $this->chamado->usuario->nome.' abriu um novo chamado!',
            'url' => $this->url
        ];
    }
}
