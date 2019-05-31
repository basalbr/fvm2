<?php

namespace App\Notifications;

use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUsuario extends Notification
{
    use Queueable;

    private $usuario;
    private $url;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
        $this->url = route('showUsuarioToAdmin',$usuario->id);
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
            ->line('Temos um novo usuário cadastrado: ' . $this->usuario->nome)
            ->line('Para visualizar as informações desse usuário clique no botão abaixo:')
            ->action('Visualizar usuário', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo usuário')
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
            'mensagem' => $this->usuario->nome.' se cadastrou no sistema!',
            'url' => $this->url
        ];
    }
}
