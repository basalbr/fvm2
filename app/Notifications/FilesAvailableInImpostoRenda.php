<?php

namespace App\Notifications;

use App\Models\ImpostoRenda;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class FilesAvailableInImpostoRenda extends Notification
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
            ->line('Concluímos sua declaração e os documentos comprobatórios já se encontram disponíveis para download em nosso sistema.')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Declaração de IR disponível')
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
            'mensagem' => 'Concluímos sua declaração e os documentos comprobatórios já se encontram disponíveis para download em nosso sistema.',
            'url' => $this->url
        ];
    }
}
