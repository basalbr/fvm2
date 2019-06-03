<?php

namespace App\Notifications;

use App\Models\Recalculo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GuiaAvailableInRecalculo extends Notification implements ShouldQueue
{
    use Queueable;
    private $recalculo;
    private $url;

    /**
     * Recalculo constructor.
     * @param Recalculo $recalculo
     */
    public function __construct(Recalculo $recalculo)
    {
        /** @var Recalculo $recalculo*/
        $this->recalculo = $recalculo;
        $this->url = route('showRecalculoToUser', $this->recalculo->id);
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
            ->greeting('Olá ' . $this->recalculo->usuario->nome.'!')
            ->line('A sua guia referente ao recálculo '.$this->recalculo->tipo->descricao. ' já está disponível.')
            ->line('Clique no botão abaixo para acessar a guia e outras informações.')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Guia disponível em recálculo ('.$this->recalculo->tipo->descricao . ')')
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
            'mensagem' => 'A sua guia referente ao recálculo '.$this->recalculo->tipo->descricao. ' já está disponível.',
            'url' => $this->url
        ];
    }
}
