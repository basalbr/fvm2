<?php

namespace App\Notifications;

use App\Models\ImpostoRenda;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewImpostoRenda extends Notification implements ShouldQueue
{
    use Queueable;
    private $ir;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param ImpostoRenda $ir
     */
    public function __construct(ImpostoRenda $ir)
    {
        $this->ir = $ir;
        $this->url = route('showImpostoRendaToAdmin', [$this->ir->id]);
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
            ->line('Temos uma nova solicitação de declaração de imposto de renda para '.$this->ir->declarante->nome)
            ->line('Para visualizar essa solicitação, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('Att,                
                WEBContabilidade :)')
            ->subject('Novo Imposto de Renda')
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
            'mensagem' => 'Temos uma nova solicitação de declaração de imposto de renda para '.$this->ir->declarante->nome,
            'url' => $this->url
        ];
    }
}
