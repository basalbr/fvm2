<?php

namespace App\Notifications;

use App\Models\empresa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEmpresa extends Notification implements ShouldQueue
{
    use Queueable;
    private $empresa;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param empresa $empresa
     */
    public function __construct(empresa $empresa)
    {
        $this->empresa = $empresa;
        $this->url = route('showEmpresaToAdmin', [$this->empresa->id]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($notifiable->admin === 1 && $notifiable->id !== 1){
            return ['database'];
        }
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
            ->line('Temos um nova solicitação de migração de empresa de ' . $this->empresa->usuario->nome)
            ->line('Para visualizar essa solicitação, clique no botão abaixo:')
            ->action('Visualizar Empresa', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Nova empresa')
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
            'mensagem' => $this->empresa->usuario->nome.' solicita uma nova empresa!',
            'url' => $this->url
        ];
    }
}
