<?php

namespace App\Notifications;

use App\Models\OrdemPagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrdemPagamentoNewStatusAdmin extends Notification
{
    use Queueable;
    private $ordemPagamento;
    private $url;

    /**
     * OrdemPagamentoNewStatus constructor.
     * @param OrdemPagamento $ordemPagamento
     */
    public function __construct(OrdemPagamento $ordemPagamento)
    {
        $this->ordemPagamento = $ordemPagamento;
        $this->url = route('showOrdemPagamentoToAdmin', [$ordemPagamento->id]);
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
            ->greeting('Olá')
            ->line('Mudança de status em ordem de pagamento')
            ->line('A ordem de pagamento de '.$this->ordemPagamento->usuario->nome.' foi alterada para:'.$this->ordemPagamento->status)
            ->line('Para visualizar a ordem de pagamento, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo status em ordem de pagamento')
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
            'mensagem' => 'A ordem de pagamento de '.$this->ordemPagamento->usuario->nome.' foi alterada para:'.$this->ordemPagamento->status,
            'url' => $this->url
        ];
    }
}
