<?php

namespace App\Notifications;

use App\Models\ImpostoRenda;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImpostoRendaSent extends Notification implements ShouldQueue
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
        $this->url = route('showImpostoRendaToUser', [$this->ir->id]);
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
            ->line('Recebemos seus documentos para declaração do imposto de renda e estaremos realizando a análise da documentação assim que possível.')
            ->line('Quando a declaração estiver pronta você receberá uma notificação no sistema e por e-mail.')
            ->line('Para visualizar sua solicitação clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('Att,                
                WEBContabilidade :)')
            ->subject('Recebemos seus documentos do IR')
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
            'mensagem' => 'Recebemos seus documentos para declaração do imposto de renda e estaremos realizando a análise da documentação.',
            'url' => $this->url
        ];
    }
}
