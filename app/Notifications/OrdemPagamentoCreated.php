<?php

namespace App\Notifications;

use App\Models\OrdemPagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrdemPagamentoCreated extends Notification
{
    use Queueable;
    private $ordemPagamento;
    private $url;

    /**
     * OrdemPagamentoCreated constructor.
     * @param OrdemPagamento $ordemPagamento
     */
    public function __construct(OrdemPagamento $ordemPagamento)
    {
        $this->ordemPagamento = $ordemPagamento;
        $this->url = route('listOrdensPagamentoToUser');
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
            ->line('Uma nova ordem de pagamento com o valor de R$'.$this->ordemPagamento->valor.' foi gerada para você.')
            ->line('Clique no botão abaixo para acessar nosso site e visualizar suas ordens de pagamento.')
            ->action('Visualizar', $this->url)
            ->line('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Nova solicitação de pagamento')
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
            'mensagem' => 'Uma nova ordem de pagamento com o valor de R$'.$this->ordemPagamento->valor.' foi gerada para você.',
            'url' => $this->url
        ];
    }
}
