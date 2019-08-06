<?php

namespace App\Notifications;

use App\Models\OrdemPagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentPending extends Notification implements ShouldQueue
{
    use Queueable;
    private $ordemPagamento;
    private $url;

    /**
     * OrdemPagamentoPaid constructor.
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
            ->greeting('Olá ' . $this->ordemPagamento->usuario->nome.'!')
            ->line('Verificamos que você possui uma ordem de pagamento no valor de '.$this->ordemPagamento->getValorComMultaJurosFormatado().' pendente em nosso sistema que venceu em '.$this->ordemPagamento->vencimento->format('d/m/Y').'!')
            ->line('Caso você já tenha efetuado o pagamento, por favor entre em contato conosco.')
            ->line('Se você ainda não realizou o pagamento, pedimos por gentileza que você acesse nosso site através do botão abaixo e realize o pagamento para evitar a suspensão de nossos serviços.')
            ->action('Verificar Pagamentos', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Ordem de pagamento vencida')
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
            'mensagem' => 'Verificamos que você possui uma ordem de pagamento no valor de '.$this->ordemPagamento->getValorComMultaJurosFormatado().' pendente em nosso sistema que venceu em '.$this->ordemPagamento->vencimento->format('d/m/Y').'!',
            'url' => $this->url
        ];
    }
}
