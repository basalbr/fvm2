<?php

namespace App\Notifications;

use App\Models\Reuniao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReuniao extends Notification implements ShouldQueue
{
    use Queueable;
    private $reuniao;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Reuniao $reuniao
     */
    public function __construct(Reuniao $reuniao)
    {
        $this->reuniao = $reuniao;
        $this->url = route('showReuniaoToAdmin', [$this->reuniao->id]);
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
            ->line('Temos um nova solicitação de reunião de ' . $this->reuniao->usuario->nome)
            ->line('Para visualizar essa solicitação, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Nova Reunião')
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
            'mensagem' =>'Temos um nova solicitação de reunião de ' . $this->reuniao->usuario->nome,
            'url' => $this->url
        ];
    }
}
