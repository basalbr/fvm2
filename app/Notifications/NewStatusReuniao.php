<?php

namespace App\Notifications;

use App\Models\Reuniao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewStatusReuniao extends Notification implements ShouldQueue
{
    use Queueable;
    private $recalculo;
    private $url;

    /**
     * Apuracao constructor.
     * @param Reuniao $reuniao
     */
    public function __construct(Reuniao $reuniao)
    {
        /** @var Reuniao $reuniao*/
        $this->reuniao = $reuniao;
        $this->url = route('showReuniaoToUser', $this->reuniao->id);
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
            ->greeting('OlÃ¡ ' . $this->reuniao->usuario->nome.'!')
            ->line('O status da sua reunião foi alterado para: '.$this->reuniao->getStatus())
            ->line('Clique no botÃ£o abaixo para visualizar.')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferÃªncia :)')
            ->subject('Novo status na reunião')
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
            'mensagem' => 'O status da sua reunião foi alterado para: '.$this->reuniao->getStatus(),
            'url' => $this->url
        ];
    }
}
