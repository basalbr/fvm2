<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MessageFromSite extends Notification
{
    use Queueable;
    private $mensagem;
    private $url;

    /**
     * MessageFromSite constructor.
     * @param $mensagem
     */
    public function __construct($mensagem)
    {
        $this->mensagem = $mensagem;
        $this->url = route('showMessageFromSiteToAdmin', [$this->mensagem->id]);
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
            ->greeting('Olá!')
            ->line('Você recebeu uma mensagem de '.$this->mensagem->nome. ' com o assunto:'.$this->mensagem->assunto)
            ->line('Para visualizar e responder a mensagem, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo contato do site')
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
            'mensagem' => 'Você recebeu uma mensagem de '.$this->mensagem->nome. ' com o assunto:'.$this->mensagem->assunto,
            'url' => $this->url
        ];
    }
}
