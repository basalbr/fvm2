<?php

namespace App\Notifications;

use App\Models\Funcionario;
use App\Models\Ponto;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PontosRequested extends Notification
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
        $this->url = route('showPontoToUser', [$this->ponto->id]);
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
            ->greeting('Olá '.$this->ponto->empresa->usuario->nome.'!')
            ->line('Precisamos que você nos envie os registros de ponto dos funcionários da empresa '.$this->ponto->empresa->nome_fantasia.'.')
            ->line('Pedimos por gentileza que eles sejam enviados no máximo até '.$this->ponto->periodo->addMonths(1)->addDays(1)->format('d/m/Y').' para que você evite multas.')
            ->line('Para visualizar e enviar os registros, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('Att,                
                WEBContabilidade :)')
            ->subject('Precisamos dos registros de ponto')
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
            'mensagem' => 'Precisamos que você nos envie os registros de ponto dos funcionários da empresa '.$this->ponto->empresa->nome_fantasia.'.',
            'url' => $this->url
        ];
    }
}
