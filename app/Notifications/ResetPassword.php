<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    public $email;

    /**
     * Create a notification instance.
     *
     * @param  string $token
     * @param  string $email
     * @return void
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Olá!')
            ->line('Você está recebendo este e-mail porque recebemos uma solicitação de alteração de senha para a sua conta.')
            ->action('Alterar Senha', route('resetPassword', [$this->email, $this->token]))
            ->line('Se você não solicitou nenhuma alteração de senha, por favor ignore este e-mail.')
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)');
    }
}
