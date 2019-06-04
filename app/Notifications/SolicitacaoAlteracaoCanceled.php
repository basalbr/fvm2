<?php

namespace App\Notifications;

use App\Models\Alteracao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitacaoAlteracaoCanceled extends Notification implements ShouldQueue
{
    use Queueable;
    private $alteracao;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Alteracao $alteracao
     */
    public function __construct(Alteracao $alteracao)
    {
        $this->alteracao = $alteracao;
        $this->url = route('showSolicitacaoAlteracaoToUser', [$this->alteracao->id]);
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
            ->line('A solicitação de alteração '.$this->alteracao->getDescricao().' para a empresa ' . $this->alteracao->empresa->nome_fantasia. ' foi cancelada.')
            ->line('Para visualizar essa solicitação, clique no botão abaixo:')
            ->action('Visualizar solicitação', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Alteração '.$this->alteracao->tipo->descricao. ' foi cancelada')
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
            'mensagem' => 'A solicitação de alteração '.$this->alteracao->tipo->descricao.' para a empresa ' . $this->alteracao->empresa->nome_fantasia. ' foi cancelada.',
            'url' => $this->url
        ];
    }
}
