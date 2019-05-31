<?php

namespace App\Notifications;

use App\Models\Apuracao;
use App\Models\Recalculo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewStatusRecalculo extends Notification
{
    use Queueable;
    private $recalculo;
    private $url;

    /**
     * Apuracao constructor.
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
            ->line('O status do recálculo '.$this->recalculo->tipo->descricao. ' foi alterado para: '.$this->recalculo->getStatus())
            ->line('Clique no botão abaixo para visualizar o processo.')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo status no recálculo '.$this->recalculo->tipo->descricao)
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
            'mensagem' => 'O status do recálculo '.$this->recalculo->tipo->descricao. ' foi alterado para: '.$this->recalculo->status,
            'url' => $this->url
        ];
    }
}
