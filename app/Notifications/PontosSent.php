<?php

namespace App\Notifications;

use App\Models\Funcionario;
use App\Models\Ponto;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PontosSent extends Notification
{
    use Queueable;
    private $ponto;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Ponto $ponto
     */
    public function __construct(Ponto $ponto)
    {
        $this->ponto = $ponto;
        $this->url = route('showPontoToAdmin', [$this->ponto->id]);
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
            ->greeting('Olá !')
            ->line('O usuário '.$this->ponto->empresa->usuario->nome.' enviou os registros de ponto da empresa '.$this->ponto->empresa->nome_fantasia.' do período '.$this->ponto->periodo->format('m/Y').'.')
            ->line('Para visualizar, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('Att,                
                WEBContabilidade :)')
            ->subject('Pontos de funcionários enviados')
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
            'mensagem' => 'O usuário '.$this->ponto->empresa->usuario->nome.' enviou os registros de ponto da empresa '.$this->ponto->empresa->nome_fantasia.' do período '.$this->ponto->periodo->format('m/Y').'.',
            'url' => $this->url
        ];
    }
}
