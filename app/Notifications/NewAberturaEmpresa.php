<?php

namespace App\Notifications;

use App\Models\AberturaEmpresa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAberturaEmpresa extends Notification implements ShouldQueue
{
    use Queueable;
    private $aberturaEmpresa;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param AberturaEmpresa $aberturaEmpresa
     */
    public function __construct(AberturaEmpresa $aberturaEmpresa)
    {
        $this->aberturaEmpresa = $aberturaEmpresa;
        $this->url = route('showAberturaEmpresaToAdmin', [$this->aberturaEmpresa->id]);
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
            ->line('Temos um nova solicitação de abertura de empresa de ' . $this->aberturaEmpresa->usuario->nome)
            ->line('Para visualizar essa solicitação, clique no botão abaixo:')
            ->action('Visualizar Abertura de Empresa', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Nova abertura de empresa')
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
            'mensagem' => $this->aberturaEmpresa->usuario->nome.' solicita uma abertura de empresa!',
            'url' => $this->url
        ];
    }
}
