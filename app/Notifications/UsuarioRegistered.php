<?php

namespace App\Notifications;

use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UsuarioRegistered extends Notification
{
    use Queueable;

    private $usuario;
    private $url;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
        $this->url = route('dashboard');
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
            ->greeting('Olá ' . $this->ordemPagamento->usuario->nome)
            ->line('Seu pagamento no valor de R$'.$this->ordemPagamento->valor.' foi efetuado com sucesso!')
            ->line('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Pagamento recebido')
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
            'mensagem' => 'Seu pagamento no valor de R$'.$this->ordemPagamento->valor.' foi efetuado com sucesso!',
            'url' => $this->url
        ];
    }
}
