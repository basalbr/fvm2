<?php

namespace App\Notifications;

use App\Models\ImpostoRenda;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewStatusImpostoRenda extends Notification implements ShouldQueue
{
    use Queueable;
    private $ir;
    private $url;

    /**
     * ImpostoRenda constructor.
     * @param ImpostoRenda $ir
     */
    public function __construct(ImpostoRenda $ir)
    {
        /** @var ImpostoRenda $ir*/
        $this->ir = $ir;
        $this->url = route('showImpostoRendaToUser', $this->ir->id);
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
            ->greeting('Olá ' . $this->ir->usuario->nome.'!')
            ->line('O status da sua declaração de imposto de renda foi alterado para: '.$this->ir->getStatus())
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo status em declaração de IR')
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
            'mensagem' => 'O status da sua declaração de imposto de renda foi alterado para: '.$this->ir->getStatus(),
            'url' => $this->url
        ];
    }
}
