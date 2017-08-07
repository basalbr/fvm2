<?php

namespace App\Notifications;

use App\Models\Chat;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewChat extends Notification
{
    use Queueable;
    private $chat;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param chat $chat
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
        $this->url = route('showChatToAdmin', [$this->chat->id]);
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
            ->greeting('Olá!')
            ->line('Temos um novo chat de ' . $this->chat->nome)
            ->line('Para visualizar esse chat, clique no botão abaixo:')
            ->action('Visualizar chat', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo chat')
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
            'mensagem' => 'Temos um novo chat de ' . $this->chat->nome,
            'url' => $this->url
        ];
    }
}
