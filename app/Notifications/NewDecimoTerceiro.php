<?php

namespace App\Notifications;

use App\Models\Chamado;
use App\Models\DecimoTerceiro;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewDecimoTerceiro extends Notification
{
    use Queueable;
    private $decimoTerceiro;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param DecimoTerceiro $decimoTerceiro
     */
    public function __construct(DecimoTerceiro $decimoTerceiro)
    {
        $this->decimoTerceiro = $decimoTerceiro;
        $this->url = route('showDecimoTerceiroToUser', [$this->decimoTerceiro->id]);
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
            ->greeting('Olá '.$notifiable->nome.'!')
            ->line('Disponibilizamos os documentos referentes ao décimo terceiro da empresa '.$this->decimoTerceiro->empresa->nome_fantasia.' ('.$this->decimoTerceiro->empresa->razao_social.').')
            ->line('Para visualizar esses documentos basta clicar no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Décimo terceiro disponível')
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
            'mensagem' => 'Disponibilizamos os documentos referentes ao décimo terceiro da empresa '.$this->decimoTerceiro->empresa->nome_fantasia.' ('.$this->decimoTerceiro->empresa->razao_social.').',
            'url' => $this->url
        ];
    }
}
